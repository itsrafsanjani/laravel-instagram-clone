<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class UpgradeToLaravel12 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade:laravel12
                            {--check-only : Only check compatibility without making changes}
                            {--skip-shift : Skip Laravel Shift GitHub fallback}
                            {--detail : Show detailed output during processing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks and upgrades Composer packages to Laravel 12 compatible versions';

    /**
     * Laravel Shift GitHub organization URL
     */
    protected const SHIFT_GITHUB_URL = 'https://github.com/laravel-shift/';

    /**
     * Known Laravel Shift compatibility branches
     */
    protected const SHIFT_COMPATIBILITY_BRANCHES = [
        'l12-compatibility',
        'laravel-12',
        'laravel12',
        'l12',
        'master',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Laravel 12 package compatibility check...');

        $composerJson = $this->getComposerJson();

        if (empty($composerJson)) {
            $this->error('Could not find or parse composer.json');
            return 1;
        }

        $packagesToCheck           = $composerJson['require'] ?? [];
        $packagesToUpdate          = [];
        $packagesToUseShift        = [];
        $unchangedPackages         = [];
        $alreadyCompatiblePackages = [];

        $this->info('Checking '.count($packagesToCheck).' dependencies...');

        $this->info("\nPriority order:");
        $this->info("1. Use current version if it already supports Laravel 12");
        $this->info("2. Use newer version from Packagist with Laravel 12 support if available");
        $this->info("3. Only fall back to Laravel Shift forks if no other option exists");
        $this->newLine();

        $bar = $this->output->createProgressBar(count($packagesToCheck));

        if (! $this->option('detail') && ! $this->getOutput()->isVerbose()) {
            $bar->start();
        }

        foreach ($packagesToCheck as $package => $version) {
            // Skip PHP and ext-* dependencies
            if ($package === 'php' || Str::startsWith($package, 'ext-')) {
                if (! $this->option('detail') && ! $this->getOutput()->isVerbose()) {
                    $bar->advance();
                }
                continue;
            }

            // Skip Laravel framework packages
            if (Str::startsWith($package, 'laravel/framework')) {
                if (! $this->option('detail') && ! $this->getOutput()->isVerbose()) {
                    $bar->advance();
                }
                continue;
            }

            // Display package being checked
            if (! $this->option('detail') && ! $this->getOutput()->isVerbose()) {
                $bar->clear();
            }
            $this->info("\nChecking {$package} (current: {$version})...");

            // PRIORITY 1: Check if current version already supports Laravel 12
            $isCurrentVersionCompatible = $this->isCurrentVersionCompatible($package, $version);

            if ($isCurrentVersionCompatible) {
                $this->info("✅ Current version already compatible with Laravel 12 - keeping as is");
                $alreadyCompatiblePackages[$package] = $version;
                if (! $this->option('detail') && ! $this->getOutput()->isVerbose()) {
                    $bar->display();
                    $bar->advance();
                }
                continue;
            }

            // PRIORITY 2: Find any Laravel 12 compatible version on Packagist
            $laravel12Version = $this->findLaravel12CompatibleVersion($package);

            if ($laravel12Version) {
                $this->info("✅ Found Laravel 12 compatible version on Packagist: {$laravel12Version}");
                $packagesToUpdate[$package] = $laravel12Version;
                if (! $this->option('detail') && ! $this->getOutput()->isVerbose()) {
                    $bar->display();
                    $bar->advance();
                }
                continue;
            }

            // PRIORITY 3: Only use Laravel Shift if explicitly enabled
            if (! $this->option('skip-shift')) {
                $shiftForkExists = $this->checkShiftForkExists($package);

                if ($shiftForkExists) {
                    $branch = $this->getShiftBranch($package);
                    $this->info("⚠️ Falling back to Laravel Shift fork with branch: {$branch}");
                    $packagesToUseShift[$package] = $branch;
                    if (! $this->option('detail') && ! $this->getOutput()->isVerbose()) {
                        $bar->display();
                        $bar->advance();
                    }
                    continue;
                }
            }

            // No compatible version found anywhere
            $this->warn("❌ No Laravel 12 compatible version found for {$package}");
            $unchangedPackages[$package] = $version;

            if (! $this->option('detail') && ! $this->getOutput()->isVerbose()) {
                $bar->display();
                $bar->advance();
            }
        }

        if (! $this->option('detail') && ! $this->getOutput()->isVerbose()) {
            $bar->finish();
        }
        $this->newLine(2);

        // Display results
        $this->displayResults($packagesToUpdate, $packagesToUseShift, $unchangedPackages, $alreadyCompatiblePackages);

        // Apply changes if not in check-only mode
        if (! $this->option('check-only')) {
            // If we have packages to update or use shift, apply the changes
            if (! empty($packagesToUpdate) || ! empty($packagesToUseShift)) {
                $this->applyChanges($composerJson, $packagesToUpdate, $packagesToUseShift);
            }
            else {
                $this->info('No changes to apply.');
            }
        }

        return 0;
    }

    /**
     * Get the composer.json content as an array
     */
    protected function getComposerJson(): array
    {
        $composerJsonPath = base_path('composer.json');

        if (! file_exists($composerJsonPath)) {
            return [];
        }

        return json_decode(file_get_contents($composerJsonPath), true) ?? [];
    }

    /**
     * Check if a version constraint includes Laravel 12
     */
    protected function constraintIncludesLaravel12(string $constraint): bool
    {
        // Direct Laravel 12 version or explicit inclusion
        if (Str::contains($constraint, ['12.', '^12', '~12', '>=12'])) {
            return true;
        }

        // Version ranges with pipes - explicitly check for 12
        if (Str::contains($constraint, '|')) {
            $ranges = explode('|', $constraint);
            foreach ($ranges as $range) {
                $range = trim($range);
                if (Str::contains($range, ['12.', '^12', '~12', '>=12'])) {
                    return true;
                }
            }
        }

        // Check for wildcard constraints that might include Laravel 12
        if ($constraint === '*' || $constraint === '^*') {
            return true;
        }

        return false;
    }

    /**
     * Format version number as a proper constraint
     */
    protected function formatVersionConstraint(string $version): string
    {
        // Remove 'v' prefix if present
        $version = ltrim($version, 'v');

        // If it's not a dev/alpha/beta/RC version, add caret
        if (! preg_match('/(dev|alpha|beta|RC|x-dev)/i', $version)) {
            return "^{$version}";
        }

        return $version;
    }

    /**
     * Check if the current version is already compatible with Laravel 12
     */
    protected function isCurrentVersionCompatible(string $package, string $currentVersionConstraint): bool
    {
        try {
            $response = Http::get("https://repo.packagist.org/p2/{$package}.json");

            if (! $response->successful()) {
                return false;
            }

            $packageData = $response->json();
            $allVersions = $packageData['packages'][$package] ?? [];

            if (empty($allVersions)) {
                return false;
            }

            // Remove constraint operators and parse version numbers
            $plainVersion = preg_replace('/^[\^~>=<]/', '', $currentVersionConstraint);

            // For exact version matches (e.g., 5.4.0)
            $exactMatches = array_filter($allVersions, function ($versionData) use ($plainVersion) {
                return ($versionData['version'] ?? '') === $plainVersion;
            });

            // For constraint matches (e.g., ^5.4 matches 5.4.0, 5.4.1, etc.)
            $majorMinor         = explode('.', $plainVersion);
            $baseVersionPattern = '';

            if (count($majorMinor) >= 2) {
                $baseVersionPattern = $majorMinor[0].'.'.$majorMinor[1];
            }
            else {
                $baseVersionPattern = $majorMinor[0].'.';
            }

            $allMatches = array_filter($allVersions, function ($versionData) use ($baseVersionPattern, $plainVersion) {
                $version = $versionData['version'] ?? '';
                return $version === $plainVersion ||
                    Str::startsWith($version, $baseVersionPattern) ||
                        // For dev versions which could have different format
                    ($version && $plainVersion &&
                        str_contains($version, $plainVersion) &&
                        str_contains($version, 'dev'));
            });

            $this->info("  Found ".count($allMatches)." versions matching ".$currentVersionConstraint);

            // Check for Laravel 12 compatibility in all matching versions
            foreach ($allMatches as $versionData) {
                $requireDeps = $versionData['require'] ?? [];

                // Check framework requirements
                if (isset($requireDeps['laravel/framework'])) {
                    $frameworkReq = $requireDeps['laravel/framework'];

                    if ($this->option('detail') || $this->getOutput()->isVerbose()) {
                        $this->line("  Version {$versionData['version']} requires laravel/framework: {$frameworkReq}");
                    }

                    if ($this->constraintIncludesLaravel12($frameworkReq)) {
                        $this->info("  ✅ Current version ({$versionData['version']}) supports Laravel 12");
                        return true;
                    }
                }

                // Check individual illuminate packages
                foreach ($requireDeps as $dep => $constraint) {
                    if (Str::startsWith($dep, 'illuminate/') && $this->constraintIncludesLaravel12($constraint)) {
                        $this->info("  ✅ Current version ({$versionData['version']}) supports Laravel 12 via {$dep}");
                        return true;
                    }
                }

                // Major version heuristic - packages often align with Laravel versions
                if (preg_match('/^v?(\d+)/', $versionData['version'], $matches)) {
                    $major = (int) $matches[1];
                    if ($major >= 12) {
                        $this->info("  ✅ Current version ({$versionData['version']}) likely supports Laravel 12 by version alignment");
                        return true;
                    }
                }
            }

            // Check for packages released after Laravel 12
            $cutoffDate = '2025-02-01'; // Laravel 12 release timeframe

            foreach ($allMatches as $versionData) {
                if (isset($versionData['time']) && $versionData['time'] >= $cutoffDate) {
                    $this->info("  ✅ Current version ({$versionData['version']}) was released after Laravel 12 (on {$versionData['time']})");
                    return true;
                }
            }

            return false;
        } catch (\Exception $e) {
            $this->warn("  Error checking current version compatibility: ".$e->getMessage());
            return false;
        }
    }

    /**
     * Find a Laravel 12 compatible version for a package
     */
    protected function findLaravel12CompatibleVersion(string $package): ?string
    {
        try {
            $response = Http::get("https://repo.packagist.org/p2/{$package}.json");

            if (! $response->successful()) {
                return null;
            }

            $packageData = $response->json();
            $versions    = $packageData['packages'][$package] ?? [];

            if (empty($versions)) {
                return null;
            }

            // First, check all versions for explicit Laravel 12 support
            foreach ($versions as $versionData) {
                $versionNumber = $versionData['version'] ?? null;

                if (! $versionNumber) {
                    continue;
                }

                // Skip dev versions unless they explicitly mention Laravel 12
                if (Str::contains($versionNumber, 'dev') &&
                    ! Str::contains($versionNumber, ['laravel12', 'laravel-12', 'l12'])) {
                    continue;
                }

                // Check framework requirements
                $requireDeps = $versionData['require'] ?? [];

                if (isset($requireDeps['laravel/framework'])) {
                    $frameworkReq = $requireDeps['laravel/framework'];

                    if ($this->constraintIncludesLaravel12($frameworkReq)) {
                        $this->info("  Found Laravel 12 compatible version: {$versionNumber} with requirement: {$frameworkReq}");

                        // Format the version constraint properly
                        return $this->formatVersionConstraint($versionNumber);
                    }
                }

                // Check illuminate/* requirements
                foreach ($requireDeps as $dep => $constraint) {
                    if (Str::startsWith($dep, 'illuminate/') && $this->constraintIncludesLaravel12($constraint)) {
                        $this->info("  Found Laravel 12 compatible version via {$dep}: {$versionNumber}");

                        // Format the version constraint properly
                        return $this->formatVersionConstraint($versionNumber);
                    }
                }
            }

            // For packages that have major version numbers matching their Laravel support
            // (Commonly used in many Laravel ecosystem packages)
            if ($this->option('detail') || $this->getOutput()->isVerbose()) {
                $this->info("  Checking for major version-based compatibility...");
            }

            // Look for versions that might be numbered to match Laravel versions
            foreach ($versions as $versionData) {
                $versionNumber = $versionData['version'] ?? null;

                if (! $versionNumber) {
                    continue;
                }

                $semver = ltrim($versionNumber, 'v');
                $major  = (int) explode('.', $semver)[0];

                // Many packages use versioning that aligns with Laravel versions
                if ($major >= 12) {
                    $this->info("  Found potential Laravel 12 compatible version by major version: {$versionNumber}");
                    return $this->formatVersionConstraint($versionNumber);
                }
            }

            // Check for newer major versions released around the Laravel 12 release time
            // Many packages might be compatible but don't explicitly state it
            if ($this->option('detail') || $this->getOutput()->isVerbose()) {
                $this->info("  Checking for recently released major versions...");
            }

            $recentVersions = [];
            $cutoffDate     = '2025-02-01'; // Laravel 12 release timeframe

            foreach ($versions as $versionData) {
                if (empty($versionData['time']) || empty($versionData['version'])) {
                    continue;
                }

                if ($versionData['time'] >= $cutoffDate) {
                    $recentVersions[] = $versionData;
                }
            }

            // Sort recent versions by time (newest first)
            usort($recentVersions, function ($a, $b) {
                return strtotime($b['time']) - strtotime($a['time']);
            });

            if (! empty($recentVersions)) {
                $latestVersion = $recentVersions[0]['version'];
                $this->info("  Found recent release that might be Laravel 12 compatible: {$latestVersion}");
                return $this->formatVersionConstraint($latestVersion);
            }

            return null;
        } catch (\Exception $e) {
            $this->warn("  Error checking for Laravel 12 compatible version: ".$e->getMessage());
            return null;
        }
    }

    /**
     * Check if a Laravel Shift fork exists for a package
     */
    protected function checkShiftForkExists(string $package): bool
    {
        $packageName = explode('/', $package)[1] ?? '';

        if (empty($packageName)) {
            return false;
        }

        if ($this->option('detail') || $this->getOutput()->isVerbose()) {
            $this->line("  Checking Laravel Shift fork for {$package}...");
        }

        try {
            foreach (self::SHIFT_COMPATIBILITY_BRANCHES as $branch) {
                $response = Http::head(self::SHIFT_GITHUB_URL.$packageName.'/tree/'.$branch);

                if ($response->successful()) {
                    $this->info("  Found Laravel Shift fork for {$package} with branch: {$branch}");
                    return true;
                }
            }

            if ($this->option('detail') || $this->getOutput()->isVerbose()) {
                $this->line("  No Laravel Shift fork found for {$package}");
            }
            return false;
        } catch (\Exception $e) {
            $this->warn("  Error checking Laravel Shift fork for {$package}: ".$e->getMessage());
            return false;
        }
    }

    /**
     * Get the branch name for a Laravel Shift fork
     */
    protected function getShiftBranch(string $package): string
    {
        $packageName = explode('/', $package)[1] ?? '';

        if (empty($packageName)) {
            return 'l12-compatibility';
        }

        foreach (self::SHIFT_COMPATIBILITY_BRANCHES as $branch) {
            $response = Http::head(self::SHIFT_GITHUB_URL.$packageName.'/tree/'.$branch);

            if ($response->successful()) {
                return $branch;
            }
        }

        return 'l12-compatibility'; // Default
    }

    /**
     * Display results in a formatted table
     */
    protected function displayResults(
        array $packagesToUpdate,
        array $packagesToUseShift,
        array $unchangedPackages = [],
        array $alreadyCompatiblePackages = []
    ): void {
        if (empty($packagesToUpdate) && empty($packagesToUseShift) && empty($alreadyCompatiblePackages)) {
            $this->info('No Laravel 12 compatible packages found to update.');
        }

        if (! empty($alreadyCompatiblePackages)) {
            $this->info('Packages already compatible with Laravel 12 (no changes needed):');
            $this->table(
                ['Package', 'Current Version'],
                collect($alreadyCompatiblePackages)->map(fn ($version, $package) => [$package, $version])->toArray()
            );
        }

        if (! empty($packagesToUpdate)) {
            $this->info('Packages with newer Laravel 12 compatible versions on Packagist:');
            $this->table(
                ['Package', 'Compatible Version'],
                collect($packagesToUpdate)->map(fn ($version, $package) => [$package, $version])->toArray()
            );
        }

        if (! empty($packagesToUseShift)) {
            $this->info('Packages with Laravel Shift compatibility forks (only used when no official version exists):');
            $this->table(
                ['Package', 'Shift Branch'],
                collect($packagesToUseShift)->map(fn ($branch, $package) => [$package, $branch])->toArray()
            );
        }

        if (! empty($unchangedPackages)) {
            $this->info('Packages that need manual review:');
            $this->table(
                ['Package', 'Current Version'],
                collect($unchangedPackages)->map(fn ($version, $package) => [$package, $version])->toArray()
            );

            $this->comment('These packages have no Laravel 12 compatible versions on Packagist or Laravel Shift.');
            $this->comment('You may need to check these packages manually or find alternatives.');
        }

        // Summary
        $this->newLine();
        $this->line('Summary:');
        $this->line('- '.count($alreadyCompatiblePackages).' packages already compatible');
        $this->line('- '.count($packagesToUpdate).' packages to update via Packagist');
        $this->line('- '.count($packagesToUseShift).' packages to update via Laravel Shift');
        $this->line('- '.count($unchangedPackages).' packages need manual review');
    }

    /**
     * Apply changes to composer.json and run composer update
     */
    protected function applyChanges(array $composerJson, array $packagesToUpdate, array $packagesToUseShift): void
    {
        if (empty($packagesToUpdate) && empty($packagesToUseShift)) {
            $this->info('No changes to apply.');
            return;
        }

        if (! $this->confirm('Do you want to update your composer.json and run composer update?', true)) {
            return;
        }

        // Back up composer.json
        $backupPath = base_path('composer.json.backup-'.time());
        copy(base_path('composer.json'), $backupPath);
        $this->info("Backed up composer.json to {$backupPath}");

        // Update regular packages
        if (! empty($packagesToUpdate)) {
            $this->info('Updating packages from Packagist:');
            $updatedPackages = [];

            foreach ($packagesToUpdate as $package => $version) {
                $oldVersion                        = $composerJson['require'][$package] ?? 'unknown';
                $composerJson['require'][$package] = $version;
                $updatedPackages[]                 = [$package, $oldVersion, $version];
            }

            $this->table(
                ['Package', 'Old Version', 'New Version'],
                $updatedPackages
            );
        }

        // Add repositories and update for Shift forks
        if (! empty($packagesToUseShift)) {
            $this->info('Adding Laravel Shift repositories:');
            $composerJson['repositories'] = $composerJson['repositories'] ?? [];
            $shiftUpdates                 = [];

            foreach ($packagesToUseShift as $package => $branch) {
                $packageName = explode('/', $package)[1] ?? '';
                $oldVersion  = $composerJson['require'][$package] ?? 'unknown';
                $newVersion  = "dev-{$branch}";

                // Only add repository if it doesn't exist
                $repoExists = false;
                foreach ($composerJson['repositories'] as $repo) {
                    if (isset($repo['url']) && Str::contains($repo['url'], $packageName)) {
                        $repoExists = true;
                        break;
                    }
                }

                if (! $repoExists) {
                    $repoUrl                        = self::SHIFT_GITHUB_URL.$packageName.'.git';
                    $composerJson['repositories'][] = [
                        'type' => 'vcs',
                        'url'  => $repoUrl
                    ];
                    $this->line("  Added repository: {$repoUrl}");
                }

                // Update package version to use branch
                $composerJson['require'][$package] = $newVersion;
                $shiftUpdates[]                    = [$package, $oldVersion, $newVersion, "dev-{$branch}"];
            }

            $this->table(
                ['Package', 'Old Version', 'New Version', 'Branch'],
                $shiftUpdates
            );

            $this->comment('Note: Laravel Shift forks are only used when no official compatible version exists on Packagist.');
            $this->comment('      Consider switching back to official packages when they add Laravel 12 support.');
        }

        // Save composer.json with nice formatting
        file_put_contents(
            base_path('composer.json'),
            json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );

        $this->info('Updated composer.json');

        // Run composer update with specific options
        if ($this->confirm('Run composer update now?', true)) {
            // Composer options
            if ($this->confirm('Would you like to update packages one by one?', false)) {
                $this->updatePackagesIndividually($packagesToUpdate, $packagesToUseShift);
            }
            else {
                $this->updateAllPackages();
            }
        }
    }

    /**
     * Update packages one by one for better error control
     */
    protected function updatePackagesIndividually(array $packagesToUpdate, array $packagesToUseShift): void
    {
        // First update standard packages
        foreach ($packagesToUpdate as $package => $version) {
            $this->info("Updating {$package} to {$version}...");

            $process = new Process(['composer', 'require', "{$package}:{$version}", '--with-all-dependencies']);
            $process->setTimeout(null);

            try {
                $process->mustRun(function ($type, $buffer) {
                    echo $buffer;
                });
                $this->info("Successfully updated {$package}.");
            } catch (ProcessFailedException $exception) {
                $this->error("Failed to update {$package}:");
                $this->line($exception->getMessage());

                if (! $this->confirm('Continue with remaining updates?', true)) {
                    break;
                }
            }
        }

        // Then update Laravel Shift packages
        foreach ($packagesToUseShift as $package => $branch) {
            $this->info("Updating {$package} to Laravel Shift branch {$branch}...");

            $process = new Process(['composer', 'require', "{$package}:dev-{$branch}", '--with-all-dependencies']);
            $process->setTimeout(null);

            try {
                $process->mustRun(function ($type, $buffer) {
                    echo $buffer;
                });
                $this->info("Successfully updated {$package}.");
            } catch (ProcessFailedException $exception) {
                $this->error("Failed to update {$package}:");
                $this->line($exception->getMessage());

                if (! $this->confirm('Continue with remaining updates?', true)) {
                    break;
                }
            }
        }
    }

    /**
     * Update all packages at once
     */
    protected function updateAllPackages(): void
    {
        $this->info('Running composer update for all packages...');

        $process = new Process(['composer', 'update', '--with-all-dependencies']);
        $process->setTimeout(null);

        try {
            $process->mustRun(function ($type, $buffer) {
                echo $buffer;
            });

            $this->info('Composer update completed successfully.');
        } catch (ProcessFailedException $exception) {
            $this->error('Composer update failed:');
            $this->line($exception->getMessage());

            // Restore backup
            $backupPath = base_path('composer.json.backup-'.time());
            if (file_exists($backupPath) && $this->confirm('Do you want to restore the backup of composer.json?', true)) {
                copy($backupPath, base_path('composer.json'));
                $this->info('Backup restored.');
            }
        }
    }
}

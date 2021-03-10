<template>
    <div>
        <button
            class="btn btn-sm btn-primary ml-4"
            @click="followUser"
            v-text="buttonText"
        ></button>
    </div>
</template>

<script>
export default {
    props: ["username", "follows"],

    mounted() {
        console.log("FollowButton Component mounted.");
    },

    data: function () {
        return {
            status: this.follows,
        };
    },

    methods: {
        followUser() {
            axios
                .post("/follows/" + this.username)
                .then((response) => {
                    this.status = !this.status;
                })
                .catch((errors) => {
                    if (errors.response.status === 401) {
                        window.location = "/login";
                    }
                });
        },
    },

    computed: {
        buttonText() {
            return this.status ? "Unfollow" : "Follow";
        },
    },
};
</script>

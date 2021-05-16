<template>
    <div>
        {{ likeCount }} <i @click.prevent="likeIt"  :class="status == 1 ? 'fas fa-heart text-danger likeBtn' : 'far fa-heart text-danger likeBtn'" data-toggle="tooltip"
                           title="Like"></i>
    </div>
</template>

<script>
export default {
    props: [
        'postSlug',
        'user',
        'likes',
        'likeStatus'
    ],

    mounted() {
        // console.log("FollowButton Component mounted.");
        // console.log("like status" + this.likeStatus)
    },

    data: function () {
        return {
            'likeCount': 0,
            'status': 0
        };
    },

    created() {
        this.likeCount = this.likes
        this.status = this.likeStatus ? this.likeStatus : 0
    },

    methods: {
        likeIt() {
            if (this.user) {
                axios.post("/likes/" + this.postSlug)
                    .then((response) => {
                        if (response.data === 'deleted') {
                            this.likeCount -= 1;
                            this.status = 0;
                        } else {
                            this.likeCount += 1;
                            this.status = 1;
                        }
                    })
                    .catch((errors) => {
                        if (errors.response.status === 401) {
                            window.location = "/login";
                        }
                    });
            } else {
                window.location = 'login'
            }

            // console.log(this.postSlug);
            // console.log("like-button clicked");
        },
    },

    computed: {
        buttonText() {
            return this.status ? "Unfollow" : "Follow";
        },
    },
};
</script>

<template>
  <v-layout>
    <v-flex xs12 sm12 v-for="(v,index) in video" :key="v.id">
      <v-card>
        <v-container fill-height fluid>
          <v-layout fill-height>
            <v-flex xs12 sm12 align-end flexbox>
              <video ref="videoRef" :src="`${v.url}`" id="video-container" width="100%" controls></video>
              <div>
                <span>Views {{v.views}}</span>
                <v-btn flat icon ref="thumb_up" @click="like(v.id)" :color="v.isLike?'blue':'grey'">
                  <v-icon>thumb_up</v-icon>
                </v-btn>
                <span>{{v.likeNum}}</span>

                <v-btn
                  flat
                  icon
                  ref="thumb_down"
                  @click="dislike(v.id)"
                  :color="!v.isLike?'blue':'grey'"
                >
                  <v-icon>thumb_down</v-icon>
                </v-btn>
              </div>
            </v-flex>
          </v-layout>
        </v-container>
        <v-container fill-height fluid>
          <v-layout fill-height>
            <v-flex xs6 sm6 offset-sm1 align-end flexbox>
              <span class="title">{{v.title}}</span>
              <v-flex xs12 align-end flexbox>
                <v-card-title>
                  <div>
                    <span class="grey--text" style="padding-right:20%">{{v.channel.name}}</span>
                    <v-btn
                      :color="v.isSubscribe?'grey':'red'"
                      :ref="'channel_'+index"
                      @click="subsToggle(v.channel.id,index)"
                    >{{v.isSubscribe?'unSubscribe':'Subscribe'}}</v-btn>
                    <br>
                    <span>{{v.channel.name}}</span>
                    <br>
                    <span>{{v.description}}</span>
                  </div>
                </v-card-title>
              </v-flex>
            </v-flex>
          </v-layout>
        </v-container>

        <v-container fill-height fluid>
          <v-layout fill-height>
            <comment :comments="v.comments" :video_id="$route.params.id"></comment>
          </v-layout>
        </v-container>
      </v-card>
    </v-flex>
  </v-layout>
</template>
<script>
import comment from "./comment.vue";
export default {
  components: {
    comment: comment
  },
  data() {
    return {
      video: [
        {
          channel: {},
          comments: []
        }
      ],
      comments: []
    };
  },
  created() {
    this.$store
      .dispatch("videos/getSpecificVideos", { id: this.$route.params.id })
      .then(res => {
        this.video = res.data.data.Videos;
        //      this.comments = res.data.data.Videos[0].comments;
        this.$nextTick();
      })
      .catch(err => {});
  },
  mounted() {
    this.$store
      .dispatch("videos/increaseView", { id: this.$route.params.id })
      .then(res => {})
      .catch(err => {});
  },
  methods: {
    like(video_id) {
      this.$store
        .dispatch("likes/createLikes", { video_id: video_id })
        .then(res => {
          console.log(res);
          if (
            res.data.data.mutationLikes &&
            res.data.data.mutationLikes.id != -1
          ) {
            this.changeColor(this.$refs["thumb_up"][0].$el, "grey", "blue");
            this.changeColor(this.$refs["thumb_down"][0].$el, "blue", "grey");
            this.video[0].likeNum++;
            this.$toaster.success("like :D");
          } else if (res.data.errors.length > 0) {
            this.$toaster.success(res.data.errors[0].message);
          }
        })
        .catch(err => {
          console.log(err);
          this.$toaster.error("like error :(");
        });
    },
    dislike(video_id) {
      this.$store
        .dispatch("likes/deleteLikes", { video_id: video_id })
        .then(res => {
          if (
            res.data.data.mutationLikes &&
            res.data.data.mutationLikes.id != -1
          ) {
            this.changeColor(this.$refs["thumb_up"][0].$el, "blue", "grey");
            this.changeColor(this.$refs["thumb_down"][0].$el, "grey", "blue");
            this.$toaster.success("dislike :(");
            this.video[0].likeNum--;
          } else if (res.data.errors.length > 0) {
            this.$toaster.success(res.data.errors[0].message);
          }
        })
        .catch(err => {
          console.log(err);
          this.$toaster.error("dislike error :(");
        });
    },
    subsToggle(id, index) {
      this.$store
        .dispatch("subsToggle", {
          key: "channel_",
          custom_id: id,
          id: index,
          refs: this.$refs
        })
        .then(res => {
          if (res == -1) {
            this.$tosater.error("Try later error happened");
          }
        });
    },
    changeColor(btn, grey, blue) {
      let newClass = btn.getAttribute("class").replace(grey, blue);
      btn.setAttribute("class", newClass);
    }
  }
};
</script>

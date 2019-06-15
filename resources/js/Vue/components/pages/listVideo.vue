<template>
  <v-layout align-content-space-between wrap>
    <v-flex xs12 sm12>
      <v-card>
        <v-container fluid>
          <v-layout v-for="(video,index) in videos" :key="video.id" tag="button">
            <v-flex xs6 align-end flexbox>
              <video
                ref="videoRef"
                :src="`${video.url}`"
                id="video-container"
                width="100%"
                controls
              ></video>
              <slot>
                <v-btn
                  v-show="$store.getters['users/getCurrentUser'].id == video.user_id"
                  @click="deleteVideo(video.id,index)"
                  small
                  color="error"
                >Delete</v-btn>
              </slot>
            </v-flex>
            <v-flex xs6 sm6 offset-sm1 align-end flexbox @click="specificVideo(video.id)">
              <span class="headline">{{video.title}}</span>
              <br>
              <span class="grey--text">{{video.views}} View</span>
              <v-flex xs12 align-end flexbox>
                <v-card-title>
                  <div>
                    <span class="grey--text">{{video.channel?video.channel.name:""}}</span>
                    <br>
                    <span>{{video.created_at}}</span>
                    <br>
                    <span>{{video.description}}</span>
                  </div>
                </v-card-title>
              </v-flex>
            </v-flex>
          </v-layout>
        </v-container>
      </v-card>
    </v-flex>
  </v-layout>
</template>
<script>
export default {
  props: ["videos"],

  created() {},
  methods: {
    specificVideo(id) {
      this.$router.push({ name: "specificVideo", params: { id: id } });
    },
    deleteVideo(id, index) {
      this.$store
        .dispatch("videos/deleteVideos", { id: id })
        .then(res => {
          console.log(res.data.data.mutationVideos);
          if (
            res.data.data.mutationVideos &&
            res.data.data.mutationVideos.id != -1
          ) {
            this.videos.splice(index, 1);
            this.$toaster.success("remove done :(");
          } else if (res.data.errors.length > 0) {
            this.$toaster.error(res.data.errors[0].message);
          }
        })
        .catch(err => {
          this.$toaster.error(err + ":(");
        });
    }
  }
};
</script>


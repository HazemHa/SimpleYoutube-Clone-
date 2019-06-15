<template>
  <v-container>
      <v-flex  v-for="channel in Channels" :key="channel.id" xs12 sm12>
        <videos :videos="channel.videos"><span></span></videos>
      </v-flex>
  </v-container>
</template>
<script>
import ListOfVideo from "./listVideo.vue";

export default {
  components: {
    videos: ListOfVideo
  },
  data() {
    return {
      Channels: []
    };
  },
  created() {
    this.$store
      .dispatch("channels/getMyVideosSubs", { id: 1 })
      .then(res => {
        this.Channels = res.data.data.Channels;
      })
      .catch(err => {});
  }
};
</script>


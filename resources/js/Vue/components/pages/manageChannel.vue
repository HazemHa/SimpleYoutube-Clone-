<template>
  <v-layout row>
    <v-flex xs12>
      <v-card>
        <v-list subheader v-for="ch in channel" :key="ch.id">
          <v-subheader>({{ch?ch.name:""}})</v-subheader>
          <videos :videos="ch.videos"></videos>
        </v-list>

        <v-divider></v-divider>Add or Update your Channel
        <v-form>
          <v-text-field v-model="channelInfo.name" label="Channel Name" required></v-text-field>

          <v-text-field v-model="channelInfo.about" label="About" required></v-text-field>

          <v-btn color="success" @click="Save">Save</v-btn>
        </v-form>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import videosList from "./listVideo.vue";
export default {
  components: {
    videos: videosList
  },
  data() {
    return {
      channelInfo: {
        id: -1,
        name: "",
        logo: "",
        cover: "",
        about: "",
        user_id: 1
      },
      channel: []
    };
  },

  created() {
    this.channelInfo.user_id = this.$store.getters["users/getCurrentUser"].id;

    this.$store
      .dispatch("channels/getMyChannels", { id: this.channelInfo.user_id })
      .then(res => {
        this.channel = res.data.data.Channels;
        this.channelInfo = res.data.data.Channels;
      })
      .catch(err => {});
  },
  methods: {
    checkID(id) {
      alert(id);
    },
    setName(name) {
      if (name) {
        return name;
      }
      return name;
    },
    Save() {
      let data = this.channelInfo;

      this.$store
        .dispatch("channels/updateChannels", data)
        .then(res => {
          if (res.data.data.mutationChannels.id == -1) {
            this.$toaster.error("happend error :(");
            let result = res.data.data.mutationChannels;
            let erros = Object.keys(result);
            for (const error of erros) {
              if (Number.isInteger(result[error])) continue;
              this.$toaster.error(result[error]);
            }
          } else
            this.$toaster.success(
              "channel updated if it is not exist will create :) "
            );
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>


<!--
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
      .dispatch("channels/getMyVideosSubs")
      .then(res => {
        this.Channels = res.data.data.Channels;
      })
      .catch(err => {});
  }
};
</script>
-->


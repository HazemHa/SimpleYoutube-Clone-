<template>
  <v-container grid-list-md text-xs-center>
    <v-layout row wrap v-for="comment in comments" :key="comment.id">
      <v-flex xs12>
        <v-card class="black--text">
          <v-layout>
            <v-flex xs3>
              <v-avatar color="grey lighten-4">
                <img :src="comment.user.avatar" alt="avatar">
              </v-avatar>

              <span class="caption">{{comment.user.name}}</span>
            </v-flex>
            <v-flex xs7>
              <p>{{comment.body}}</p>
            </v-flex>
          </v-layout>
        </v-card>
      </v-flex>
    </v-layout>

    <!--
     <v-layout row wrap v-for="comment in comments" :key="comment.id">
         <v-flex xs2>
             {{comment.user.name}}
          <v-avatar
          color="grey lighten-4"
        >
          <img :src="comment.user.avatar" alt="avatar">
        </v-avatar>
       </v-flex>

        <v-flex xs10>
            <p>{{comment.body}}</p>
        </v-flex>
     </v-layout>

    -->
    <v-flex v-if="this.$store.getters['users/isAuth']">
      <v-layout row wrap>
        <v-flex xs10>
          <form>
            <v-textarea
              v-validate="'required'"
              v-model="comment.body"
              :error-messages="errors.collect('comment')"
              label="comment"
              data-vv-name="comment"
              required
            ></v-textarea>

            <v-btn @click="submit" @keydown.enter="submit">Comment</v-btn>
          </form>
        </v-flex>
        <v-flex xs2>
          <v-avatar color="red">
            <img :src="$store.getters['users/getCurrentUser'].avatar" alt="avatar">
          </v-avatar>
        </v-flex>
      </v-layout>
    </v-flex>
  </v-container>
</template>
<script>
import Vue from "vue";
import VeeValidate from "vee-validate";
import Echo from "laravel-echo";

Vue.use(VeeValidate);

export default {
  props: ["comments", "video_id"],
  $_veeValidate: {
    validator: "new"
  },

  data: () => ({
    comment: {
      body: "",
      user: {
        name: "default",
        avatar: "https://cdn.vuetifyjs.com/images/john.jpg"
      }
    },
    Echo: {},
    dictionary: {
      custom: {
        comment: {
          required: () => "comment can not be empty"
        }
      }
    }
  }),
  created() {
    this.comment.user.avatar = this.$store.getters[
      "users/getCurrentUser"
    ].avatar;
    this.comment.user.name = this.$store.getters["users/getCurrentUser"].name;
    if (this.$store.getters["users/isAuth"]) {
      this.Echo = new Echo({
        broadcaster: "socket.io",
        host: "127.0.0.1:6001",
        auth: {
          headers: {
            Authorization:
              "Bearer " +
              this.$store.getters["users/getCurrentUser"].access_token
          }
        }
      });

      this.Echo.private("video." + this.video_id).listen("Comment", e => {
        this.comment = e.data;
        this.comments.push(this.comment);
      });
    }
  },
  mounted() {
    this.$validator.localize("en", this.dictionary);
  },

  methods: {
    submit() {
      console.log(this.comment);
      this.$store
        .dispatch("comments/createComments", {
          body: this.comment,
          video_id: this.video_id
        })
        .then(res => {
          //  this.comments.push(res.data.data.mutationComments);
        })
        .catch(err => {
          console.log(err);
        });
      // this.comments.push(this.comment);
      this.$validator.validateAll();
    },
    clear() {
      this.name = "";
      this.$validator.reset();
    }
  }
};
</script>

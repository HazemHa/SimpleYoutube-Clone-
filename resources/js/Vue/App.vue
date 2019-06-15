<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" fixed clipped app>
      <v-list dense>
        <v-list-tile v-if="!this.$store.getters['users/isAuth']">
          <router-link :to="{name:'trending'}" class="v-list__tile v-list__tile--link">
            <v-list-tile-action>
              <v-icon>trending_up</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>Most Popular</v-list-tile-title>
            </v-list-tile-content>
          </router-link>
        </v-list-tile>

        <v-flex v-if="this.$store.getters['users/isAuth']">
          <v-list-tile v-for="item in items" :key="item.text" @click>
            <router-link :to="{name:item.name}" class="v-list__tile v-list__tile--link">
              <v-list-tile-action>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>{{ item.text }}</v-list-tile-title>
              </v-list-tile-content>
            </router-link>
          </v-list-tile>

          <v-subheader class="mt-3 grey--text text--darken-1">SUBSCRIPTIONS</v-subheader>
          <v-list>
            <v-list-tile v-for="item in channels" :key="item.text" avatar @click>
              <router-link
                :to="{name:'subscriptionDetails',params:{id:1}}"
                class="v-list__tile v-list__tile--link"
              >
                <v-list-tile-avatar>
                  <img :src="item.logo" alt>
                </v-list-tile-avatar>
                <v-list-tile-title v-text="item.name"></v-list-tile-title>
              </router-link>
            </v-list-tile>
          </v-list>

          <router-link :to="{name:'BrowserChannels'}" class="v-list__tile v-list__tile--link">
            <v-list-tile class="mt-3" @click>
              <v-list-tile-action>
                <v-icon color="grey darken-1">add_circle_outline</v-icon>
              </v-list-tile-action>
              <v-list-tile-title class="grey--text text--darken-1">Browse Channels</v-list-tile-title>
            </v-list-tile>
          </router-link>
        </v-flex>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar color="red" dense fixed clipped-left app>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>

      <v-icon class="mx-3">fab fa-youtube</v-icon>

      <v-toolbar-title class="mr-5 align-center">
        <router-link :to="{name:'home'}" tag="button">
          <span class="title">Youtube</span>
        </router-link>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-layout row align-center style="max-width: 650px">
        <v-text-field
          :append-icon-cb="() => {}"
          placeholder="Search..."
          single-line
          append-icon="search"
          color="white"
          hide-details
          v-model="valueSearched"
          @click:append="searchByTitle"
        ></v-text-field>

        <v-flex v-if="!this.$store.getters['users/isAuth']">
          <router-link :to="{ name: 'login'}">
            <v-btn flat>
          <v-icon>fa fa-sign-in</v-icon>
            </v-btn>
          </router-link>
          <router-link :to="{ name: 'register'}">
            <v-btn flat>
              <v-icon>person_add</v-icon>
            </v-btn>
          </router-link>
        </v-flex>
        <v-flex v-else>
          <router-link :to="{ name: 'profile'}">
            <v-btn flat>
              <v-icon>account_circle</v-icon>
            </v-btn>
          </router-link>
          <v-btn flat @click="logout">
            <v-icon>exit_to_app</v-icon>
          </v-btn>
        </v-flex>
      </v-layout>
    </v-toolbar>
    <v-content>
      <router-view></router-view>
    </v-content>
  </v-app>
</template>
<script>
export default {
  data: () => ({
    drawer: null,
    valueSearched:"",
    channels: [],
    items: [
      { icon: "trending_up", text: "Most Popular", name: "trending" },
      { icon: "subscriptions", text: "Subscriptions", name: "subscriptions" },
      { icon: "add", text: "Add Video", name: "addVideo" },
      { icon: "settings", text: "mangae Channel", name: "manageChannel" }
    ]
  }),
  props: {
    source: String
  },
  created() {

        let self = this;

    setTimeout(function() {
      self.$store
        .dispatch("users/setTokenForRequest", {})
        .then(function(value) {
          if (value) {
            self.$nextTick();
          } else {
            console.log("isAuthNotAuth");
            self.$nextTick();
          }
        });
    }, 1000);


    this.$store
      .dispatch("users/getSubsChannel", { id: 1 })
      .then(res => {
        this.channels = res.data.data.Users[0].SubsChannel;
      })
      .catch(err => {});
    this.$store
      .dispatch("users/setTokenForRequest")
      .then(function(isAuth) {
        if (isAuth) {
          self.$nextTick();
        }
      })
      .catch(err => {
        self.$toaster.error(err);
      });
  },
  methods: {
    logout() {
      this.$store
        .dispatch("users/Logout")
        .then(res => {
          if (res) {
            this.$nextTick();
          }
        })
        .catch(err => {});
    },
    searchByTitle(){
       this.$router.push({name:'searchResult',params:{keyword:this.valueSearched}});
    }
  }
};
</script>
<style lang="stylus" scoped>
.v-progress-circular {
  margin: 1rem;
}

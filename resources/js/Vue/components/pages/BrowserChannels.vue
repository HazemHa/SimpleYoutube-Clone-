<template>
  <v-layout>
    <v-flex v-for="(channel,index) in channels" :key="channel.id" xs4 offset-xs-1>
      <v-avatar color="grey lighten-4">
        <img :src="channel.logo" alt="avatar">
      </v-avatar>
      <h4 class="body-1">{{channel.name}}</h4>

      <v-card-actions>
        <v-btn color="grey" :ref="'subs_'+index" @click="subsToggle(channel.id,index)">UnSubscribe</v-btn>
      </v-card-actions>
    </v-flex>
  </v-layout>
</template>
<script>
export default {
  data() {
    return {
      channels: []
    };
  },
  created() {
    this.$store
      .dispatch("users/getSubsChannel", { id: 1 })
      .then(res => {
        this.channels = res.data.data.Users[0].SubsChannel;
      })
      .catch(err => {});
  },
  methods: {
     subsToggle(id,index){
      let result  = this.$store.dispatch('subsToggle',{key:"subs_",id:index,custom_id:id,refs:this.$refs});
      if(result == -1){
     this.$tosater.error('Try later error happened');
      }
     }
  }
};
</script>


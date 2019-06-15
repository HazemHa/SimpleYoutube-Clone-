<template>
  <div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Videos</v-toolbar-title>
      <v-divider
        class="mx-2"
        inset
        vertical
      ></v-divider>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="500px">
        <template v-slot:activator="{ on }">
          <v-btn color="primary" dark class="mb-2" v-on="on">New Videos</v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                
                  <v-flex xs12 sm6 md4><v-text-field v-model="editedItem.title" label="title"></v-text-field></v-flex>
<v-flex xs12 sm6 md4><v-text-field v-model="editedItem.description" label="description"></v-text-field></v-flex>
<v-flex xs12 sm6 md4><v-text-field v-model="editedItem.published" label="published"></v-text-field></v-flex>
<v-flex xs12 sm6 md4><v-text-field v-model="editedItem.url" label="url"></v-text-field></v-flex>
<v-flex xs12 sm6 md4><v-text-field v-model="editedItem.thumbnail" label="thumbnail"></v-text-field></v-flex>
<v-flex xs12 sm6 md4><v-text-field v-model="editedItem.allow_comments" label="allow_comments"></v-text-field></v-flex>
<v-flex xs12 sm6 md4><v-text-field v-model="editedItem.views" label="views"></v-text-field></v-flex>
<v-flex xs12 sm6 md4><v-text-field v-model="editedItem.channel_id" label="channel_id"></v-text-field></v-flex>
<v-flex xs12 sm6 md4><v-text-field v-model="editedItem.user_id" label="user_id"></v-text-field></v-flex>

               
              </v-layout>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
            <v-btn color="blue darken-1" flat @click="save">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="data"
      class="elevation-1"
    >
      <template v-slot:items="props">
<td class="text-xs-right">{{ props.item.title}} </td>
<td class="text-xs-right">{{ props.item.description}} </td>
<td class="text-xs-right">{{ props.item.published}} </td>
<td class="text-xs-right">{{ props.item.url}} </td>
<td class="text-xs-right">{{ props.item.thumbnail}} </td>
<td class="text-xs-right">{{ props.item.allow_comments}} </td>
<td class="text-xs-right">{{ props.item.views}} </td>
<td class="text-xs-right">{{ props.item.channel_id}} </td>
<td class="text-xs-right">{{ props.item.user_id}} </td>
        <td class="justify-center layout px-0">
          <v-icon
            small
            class="mr-2"
            @click="editItem(props.item)"
          >
            edit
          </v-icon>
          <v-icon
            small
            @click="deleteItem(props.item)"
          >
            delete
          </v-icon>
        </td>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>
  </div>
</template>
<script>
  export default {
    data: () => ({
      dialog: false,
      headers: [
{
          text: 'title',
          value: 'title'},
{
          text: 'description',
          value: 'description'},
{
          text: 'published',
          value: 'published'},
{
          text: 'url',
          value: 'url'},
{
          text: 'thumbnail',
          value: 'thumbnail'},
{
          text: 'allow_comments',
          value: 'allow_comments'},
{
          text: 'views',
          value: 'views'},
{
          text: 'channel_id',
          value: 'channel_id'},
{
          text: 'user_id',
          value: 'user_id'}
,
        { text: 'Actions', value: 'name', sortable: false }
      ],
      data: [],
      editedIndex: -1,
      editedItem: {
 title: '',
 description: '',
 published: '',
 url: '',
 thumbnail: '',
 allow_comments: '',
 views: '',
 channel_id: '',
 user_id: ''
      },
      defaultItem: {
 title: '',
 description: '',
 published: '',
 url: '',
 thumbnail: '',
 allow_comments: '',
 views: '',
 channel_id: '',
 user_id: ''
      }
    }),
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Videos' : 'Edit Videos'
      }
    },
    watch: {
      dialog (val) {
        val || this.close()
      }
    },
    created () {
      this.initialize()
    },
    methods: {
      initialize () {
        this.data = []
this.$store
        .dispatch("videos/getVideos")
        .then((res) => {
          this.data = res.Videos;
        })
        .catch(err => {
          console.log(err);
        });
      },
      editItem (item) {
        this.editedIndex = this.data.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },
      deleteItem (item) {
        const index = this.data.indexOf(item)
if (confirm("Are you sure you want to delete this item?")) {
        this.$store
          .dispatch("videos/deleteVideos", { id: item.id })
          .then((res) => {
            
            if (res.mutationVideos.id == -1) {
              console.log("cant delete ");
            } else {
              this.data.splice(index, 1);
            }
          })
          .catch(err => {
            console.log(err);
          });
      }
      },
      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },
      save () {
if (this.editedIndex > -1) {
        // update the record
        this.$store
          .dispatch("videos/updateVideos", this.editedItem)
          .then((res) => {
            if (res.mutationVideos.id == -1) {
              console.log("cant update ");
            } else {
              Object.assign(this.data[this.editedIndex], res.mutationVideos);
            }
          })
          .catch(err => {
            console.log(err);
          });
      } else {
        // create record
        console.log(this.editedItem);
        this.$store          .dispatch("videos/createVideos", this.editedItem)
          .then((res) => {
            this.data.push(res.mutationVideos);
          })
          .catch(err => {
            console.log(err);
          });
      }

this.close()
      }
    }
  }
</script>

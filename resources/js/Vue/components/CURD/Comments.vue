<template>
  <div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Comments</v-toolbar-title>
      <v-divider
        class="mx-2"
        inset
        vertical
      ></v-divider>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="500px">
        <template v-slot:activator="{ on }">
          <v-btn color="primary" dark class="mb-2" v-on="on">New Comments</v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                
                  <v-flex xs12 sm6 md4><v-text-field v-model="editedItem.body" label="body"></v-text-field></v-flex>
<v-flex xs12 sm6 md4><v-text-field v-model="editedItem.approved" label="approved"></v-text-field></v-flex>
<v-flex xs12 sm6 md4><v-text-field v-model="editedItem.video_id" label="video_id"></v-text-field></v-flex>
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
<td class="text-xs-right">{{ props.item.body}} </td>
<td class="text-xs-right">{{ props.item.approved}} </td>
<td class="text-xs-right">{{ props.item.video_id}} </td>
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
          text: 'body',
          value: 'body'},
{
          text: 'approved',
          value: 'approved'},
{
          text: 'video_id',
          value: 'video_id'},
{
          text: 'user_id',
          value: 'user_id'}
,
        { text: 'Actions', value: 'name', sortable: false }
      ],
      data: [],
      editedIndex: -1,
      editedItem: {
 body: '',
 approved: '',
 video_id: '',
 user_id: ''
      },
      defaultItem: {
 body: '',
 approved: '',
 video_id: '',
 user_id: ''
      }
    }),
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Comments' : 'Edit Comments'
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
        .dispatch("comments/getComments")
        .then((res) => {
          this.data = res.Comments;
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
          .dispatch("comments/deleteComments", { id: item.id })
          .then((res) => {
            
            if (res.mutationComments.id == -1) {
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
          .dispatch("comments/updateComments", this.editedItem)
          .then((res) => {
            if (res.mutationComments.id == -1) {
              console.log("cant update ");
            } else {
              Object.assign(this.data[this.editedIndex], res.mutationComments);
            }
          })
          .catch(err => {
            console.log(err);
          });
      } else {
        // create record
        console.log(this.editedItem);
        this.$store          .dispatch("comments/createComments", this.editedItem)
          .then((res) => {
            this.data.push(res.mutationComments);
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

<template>
  <v-container fluid fill-height>
    <v-layout align-center justify-center>
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-text-field v-model="name" :rules="nameRules" label="Name" required></v-text-field>

        <v-text-field v-model="email" :rules="emailRules" label="E-mail" required></v-text-field>


        <v-text-field
          v-model="password"
          :append-icon="show1 ? 'visibility_off' : 'visibility'"
          :rules="passwordRule"
          :type="show1 ? 'text' : 'password'"
          name="input-10-1"
          label="password"
          hint="At least 8 characters"
          counter
          required
        ></v-text-field>

        <v-text-field
          v-model="password_confirmation"
          :append-icon="show1 ? 'visibility_off' : 'visibility'"
          :rules="password_confirmationRule"
          :type="show1 ? 'text' : 'password'"
          name="input-10-1"
          label="confrim password"
          hint="At least 8 characters"
          counter
          required
          @click:append="show1 = !show1"
        ></v-text-field>

        <v-flex xs12>
          <image-input v-model="avatar" @input="ReceiveImage">
            <div slot="activator">
              <v-avatar size="280px" v-ripple v-if="!avatar" class="grey lighten-3 mb-3">
                <span>Click to add avatar</span>
              </v-avatar>
              <v-avatar size="280px" v-ripple v-else class="mb-3">
                <img :src="avatar.imageURL" alt="avatar">
              </v-avatar>
            </div>
          </image-input>
        </v-flex>

        <v-btn :disabled="!valid" @click="submit" color="green darken-3">submit</v-btn>
      </v-form>
    </v-layout>
  </v-container>
</template>
<script>
import ImageInput from "../../image/imageUpload.vue";

export default {
  components: {
    ImageInput: ImageInput
  },
  data: () => ({
    valid: true,
    name: "",
    show1: false,
    tempImageAsFile: null,
    avatar: { imageURL: "" },
    nameRules: [
      v => !!v || "Name is required",
      v => (v && v.length <= 10) || "Name must be less than 10 characters"
    ],
    email: "",
    emailRules: [
      v => !!v || "E-mail is required",
      v => /.+@.+/.test(v) || "E-mail must be valid"
    ],
    password: "",
    password_confirmation: "",
    passwordRule: [
      v => !!v || "Password is required",
      v => (v && v.length >= 6) || "Password must be more than 6 character"
    ],
    password_confirmationRule: [
      v => !!v || "password is required "
      //  v=> (v && this.password === v ) || 'the confirm password does not match with password',
    ],

  }),
  created() {},

  methods: {
    submit() {
      if (this.$refs.form.validate()) {
        const formData = new FormData();
        formData.append("name", this.name);
        formData.append("email", this.email);
        formData.append("password", this.password);
        formData.append("password_confirmation", this.password_confirmation);
        formData.append("image", this.tempImageAsFile);
        this.$store
          .dispatch("users/singup", formData)
          .then(res => {
            if (res.data.success) {
              this.$toaster.success("registration complete");
              this.$store.dispatch("users/singup", res.data.user);
              this.$router.push("/");
            } else {
              this.$toaster.error("registration uncomplete");
            }
          })
          .catch(err => {
            this.$toaster.error(err);
          });
      }
    },
    clear() {
      this.$refs.form.reset();
    },
    ReceiveImage(file) {
      this.tempImageAsFile = file.file;
    }
  }
};
</script>

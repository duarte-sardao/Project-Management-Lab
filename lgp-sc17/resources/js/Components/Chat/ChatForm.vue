
<template>
  <div class="divider divider-horizontal border-[1px] border-black/30 w-full"></div>
  <div class="flex w-full gap-3 pt-5 pl-3">
    <input
      id="btn-input"
      type="text"
      name="message"
      class="form-control input-sm w-full border-0 shadow-xl rounded-xl"
      placeholder="Type your message here..."
      v-model="newMessage"
      @keyup.enter="sendMessage"
    />
    <span class="input-group-btn w-56">
      <button class="btn btn-sm px-5 rounded-xl bg-mainBlue border-0 text-white" id="btn-chat" @click="sendMessage">
        Send Message ►
      </button>
    </span>
  </div>
</template>
<script>

    export default {
    props: ["user"],
    data() {
        return {
          newMessage: "",
        };
    },
    methods: {
        sendMessage() {
          console.log(this.patient);
          this.$emit("messagesent", {
            user: this.user,
            message: this.newMessage,
          });
          this.newMessage = "";
        },
    },
    };
</script>

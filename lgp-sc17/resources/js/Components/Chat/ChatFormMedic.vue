
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
    //Takes the "user" props from <chat-form> … :user="{{ Auth::user() }}"></chat-form> in the parent chat.blade.php.
    props: ["user","patient"],
    data() {
        return {
        newMessage: "",
        };
    },
    methods: {
        sendMessage() {
            //Emit a "messagesent" event including the user who sent the message along with the message content
            this.$emit("messagesent", {
                user: this.user,
            //newMessage is bound to the earlier "btn-input" input field
                message: this.newMessage,
                patient: this.patient,
            });
            //Clear the input
            this.newMessage = "";
        },
    },
};
</script>
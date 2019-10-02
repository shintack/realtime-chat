<template>
  <div class="card">
    <div class="card-header">
      Chat Panel #{{ channelData ? channelData.id : '-' }}
      <button
        class="btn btn-sm btn-danger float-right"
        @click="closeMessage"
      >
        <i class="fa fa-times"></i>
      </button>
    </div>
    <div class="card-body chat-panel">
      <!-- <div v-if="messages.lenght > 0"> -->
      <div v-for="message in messages">
        <span v-if="message.sender.id !== user.id">
          <div class="row m-0 mb-2">
            <div class="col rounded-lg border border-primary">
              <b>{{ message.sender.name }}</b>
              <br />
              {{ message.content }}
              <br />
              <small>
                <i>{{ message.created_at }}</i>
              </small>
            </div>
          </div>
        </span>
        <span v-else>
          <div class="row m-0 mb-2">
            <div class="col rounded-lg border border-success text-right">
              <b>{{ message.sender.name }}</b>
              <br />
              {{ message.content }}
              <br />
              <small>
                <i>{{ message.created_at }}</i>
              </small>
            </div>
          </div>
        </span>
      </div>
      <!-- </div> -->
    </div>
    <div class="card-footer">
      <textarea v-model="text" class="form-control"></textarea>
      <div class="row mt-2">
        <div class="col">
          <button class="btn btn-sm btn-primary">
            <i class="fa fa-paperclip"></i>
          </button>
          <button class="btn btn-sm btn-primary">
            <i class="fa fa-camera"></i>
          </button>
        </div>
        <div class="col text-right">
          <button class="btn btn-sm btn-primary" @click="sendMessage()">
            <i class="fa fa-paper-plane"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    initialData: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      user: {},
      text: "",
      channelData: {},
      messages: [
        // {
        //   user: {
        //     name: "si c",
        //     email: "email@email.com",
        //     image: "image",
        //     id: 1
        //   },
        //   message: "ini pesannya",
        //   created_at: "10-10-2019 10:00:00"
        // },
        // {
        //   user: {
        //     name: "si a",
        //     email: "email@email.com",
        //     image: "image",
        //     id: 2
        //   },
        //   message: "ini pesannya",
        //   created_at: "10-10-2019 10:00:00"
        // }
      ]
    };
  },
  methods: {
    closeMessage() {
      this.$emit("closeChannel", false);
      this.closeChannel();
    },
    getMessages() {
      axios
        .get(`/message/${this.channelData.id}`)
        .then(({ data }) => {
          this.messages = data.data;
          console.log("get message >>", this.messages);
        })
        .catch(error => {
          console.log("error >>", error);
        });
    },
    sendMessage() {
      if (this.channelData.id) {
        if (this.text) {
          axios
            .post(`/message/${this.channelData.id}`, { message: this.text })
            .then(({ data }) => {
              //   this.getMessages();
              console.log("after send >>", data.data);
              this.messages.push(data.data);
              this.text = "";
            });
        } else {
          console.log("text message required");
        }
      } else {
        console.log("cannel not connected");
      }
    },
    connectChannel() {
      console.log("new connect");
      Echo.channel(`laravel_database_${this.channelData.id}`).listen(
        "MessageSent",
        ({ message }) => {
          console.log("push message >", message);
          this.messages.push(message);
          this.newMessageNotif();
          console.log("channel connected #");
        }
      );
      this.getMessages();
    },
    closeChannel() {
      Echo.leave(`laravel_database_${this.channelData.id}`);
    },
    newMessageNotif() {
      const audio = new Audio("/hangouts_message.ogg");
      audio.play();
    }
  },
  watch: {
    initialData(value) {
      this.user = value.user;
      if (this.channelData.id) {
        console.log("close connect");
        this.closeChannel();
        console.log("set new param");
        this.channelData = value.chanelData;
        this.connectChannel();
      } else {
        this.channelData = value.chanelData;
        this.connectChannel();
      }
    }
  }
};
</script>

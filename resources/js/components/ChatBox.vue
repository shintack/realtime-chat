<template>
  <div class="container">
    <!-- <nav>
      <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
        <a
          class="nav-item nav-link active"
          id="nav-home-tab"
          data-toggle="tab"
          href="#nav-home"
          role="tab"
          aria-controls="nav-home"
          aria-selected="true"
        >
          <i class="fa fa-history"></i> History
        </a>
        <a
          class="nav-item nav-link"
          id="nav-profile-tab"
          data-toggle="tab"
          href="#nav-chat"
          role="tab"
          aria-controls="nav-profile"
          aria-selected="false"
        >
          <i class="fa fa-comments"></i> Chat
        </a>
        <a
          class="nav-item nav-link"
          id="nav-contact-tab"
          data-toggle="tab"
          href="#nav-contact"
          role="tab"
          aria-controls="nav-contact"
          aria-selected="false"
        >
          <i class="fa fa-address-book"></i> Contact
        </a>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div
        class="tab-pane fade show active"
        id="nav-home"
        role="tabpanel"
        aria-labelledby="nav-home-tab"
      >
        <contact-list
          v-if="contactShow"
          :initialData="contact"
          @openChanel="handleSuccess"
          @reloadChanel="getAllContact"
        />
      </div>
      <div class="tab-pane fade" id="nav-chat" role="tabpanel" aria-labelledby="nav-profile-tab">
        <chat-message v-if="loadMessage" :initialData="messageData" @closeChannel="handleSuccess"></chat-message>
      </div>
      <div
        class="tab-pane fade"
        id="nav-contact"
        role="tabpanel"
        aria-labelledby="nav-contact-tab"
      >...</div>
    </div>-->

    <div class="row justify-content-center">
      <div class="col-md-4">
        <contact-list
          v-if="contactShow"
          :initialData="contact"
          @openChanel="handleSuccess"
          @reloadChanel="getAllContact"
        />
      </div>
      <div class="col-md-8">
        <chat-message v-if="loadMessage" :initialData="messageData" @closeChannel="handleSuccess"></chat-message>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      contact: [],
      messageData: {},
      loadMessage: false,
      contactShow: true,
      myProfile: {}
    };
  },
  methods: {
    handleSuccess(value) {
      if (value === false) {
        console.log("close", value);
        this.panelMode(1);
      } else {
        this.messageData = {
          chanelData: value,
          messages: [],
          user: this.myProfile
        };
        if (this.messageData !== {}) {
          this.panelMode(2);
          console.log("open message >>", value);
        }
      }
    },
    getAllContact() {
      axios
        .get(`/chat-all`)
        .then(({ data }) => {
          this.contact = data.data;
        })
        .catch(error => {
          console.log("error >>", error);
        });
    },
    getMyProfile() {
      axios
        .get(`/my-profile`)
        .then(({ data }) => {
          this.myProfile = data.data;
        })
        .catch(error => {
          console.log("error >>", error);
        });
    },
    panelMode(mode = 1) {
      if (mode === 1) {
        this.loadMessage = false;
        // this.contactShow = true;
      } else {
        this.loadMessage = true;
        // this.contactShow = false;
      }
    }
  },
  created() {
    this.getAllContact();
    this.getMyProfile();
    this.panelMode(1);
  }
};
</script>

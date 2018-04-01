<template lang="html">
  <div class="page">
    <h4>Chairs:</h4>
    <ul>
      <li v-for="chair in chairs">{{ chair.name }}</li>
    </ul>
    <h4>Messages:</h4>
    <p v-for="message in messages">{{ message }}</p>
  </div>
</template>

<script>
module.exports = {
  name: 'home',
  data: function() {
    return {
      chairs: [],
      error: '',
      messages: []
    };
  },
  methods: {
    setChairs: function(res) {
      this.chairs = res;
    },
    handleError: function(err) {
      this.message = err;
    },
    addMessage: function(res) {
      this.messages.push(res.message);
    }
  },
  created: function() {

    this.$get('products/chairs', this.setChairs, {three:3});
    this.$get('products/chairs/42', null);
    this.$post('products/chairs/', this.addMessage, {name: 'Red Chair'});
    this.$put('products/chairs/42', this.addMessage, {three:3});
    this.$delete('products/chairs/42', this.addMessage, {three:3});


  }
};
</script>

<style lang="css" scoped>
.page {
  padding: 50px;
}
ul, p {
  padding-left: 50px;
}
li {
  position: relative;
  font-size: 16px;
  margin-right: 40px;
}
li:before {
  content: '';
  position: absolute;
  width: 3px;
  height: 3px;
  background-color: #111;
  top: 8px;
  left: -10px;
}
</style>

<template lang="html">
  <div class="app">
    <router-view></router-view>
  </div>
</template>

<script>

module.exports = {
  name: 'app',
  components: {
  },
  data: function() {
    return {};
  }
};
</script>

<style lang="css">

body {
  margin: 0;
  padding:0;
  font-family: serif;
  letter-spacing: .1em;
  background: #fafafa;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-rendering: optimizeLegibility;
}

ul {
  margin: 0;
  padding: 0;
}

li {
  list-style-type: none;
  display: inline-block;
}


</style>

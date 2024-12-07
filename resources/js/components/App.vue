<template>
  <div v-if="msg != null" class="alert alert-success" role="alert">
    Добавлена новая статья <strong><a :href="`/article/${msg.id}`">{{ msg.name }}</a></strong>
  </div>
</template>

<script>
export default {
  data() { return { msg: null } },
  created() {
    window.Echo.channel('test').listen('NewArticleEvent', (article) => {
      console.log(article);
      this.msg = article.article;
      // alert('Добавлена новая статья!');
    })
  }
}
</script>
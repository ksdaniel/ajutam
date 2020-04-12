<template>
  <div class="app-container">
    <el-form v-if="user" :model="user">
      <el-row :gutter="20">
        <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="6">
          <user-card :user="user" />
          <!--<user-bio />-->
        </el-col>
        <el-col :xs="24" :sm="24" :md="15" :lg="15" :xl="18">
          <user-activity :user="user" />
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
import Resource from '@/api/resource';

import UserCard from './components/UserCard';
import UserActivity from './components/UserActivity';

const userResource = new Resource('users');
export default {
  name: 'EditUser',
  components: { UserCard, UserActivity },
  data() {
    return {
      user: {},
    };
  },
  watch: {
    '$route': 'getUser',
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    this.getUser(id);
  },
  methods: {
    async getUser(id) {
      const { data } = await userResource.get(id);
      this.user = data;
    },
  },
};
</script>

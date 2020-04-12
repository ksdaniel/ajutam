<template>
  <el-card v-if="user.name">
    <div class="user-profile">
      <el-button size="small" icon="el-icon-upload" round @click="$upload.select('file')">{{ $t('account.uploadImage') }}</el-button>

      <div class="user-avatar box-center">
        <!--<pan-thumb :image="user.avatar" :height="'100px'" :width="'100px'" :hoverable="false" />-->
        <el-image
          style="width: 100px; height: 100px"
          :src="!user.avatar ? '/storage/avat-01-512.png' : '/storage/'+user.avatar"
          fit="fill"
        />
      </div>
      <div class="box-center">
        <div class="user-name text-center">
          {{ user.name }}
        </div>
        <div class="user-role text-center text-muted">
          {{ getRole() }}
        </div>
      </div>
      <!--<div class="box-social">-->
      <!--<el-table :data="social" :show-header="false">-->
      <!--<el-table-column prop="name" label="Name" />-->
      <!--<el-table-column label="Count" align="left" width="100">-->
      <!--<template slot-scope="scope">-->
      <!--{{ scope.row.count | toThousandFilter }}-->
      <!--</template>-->
      <!--</el-table-column>-->
      <!--</el-table>-->
      <!--</div>-->
      <!--<div v-if="checkRole(['admin'])" class="user-follow">-->

        <!--<button type="button" class="loginBtn loginBtn&#45;&#45;facebook" @click="facebook()">-->
          <!--{{ $t('account.connectWithFacebook') }}-->
        <!--</button>-->

        <!--<div v-if="user.facebook_token" class="text-left text-muted" style="margin-top: 10px">-->
          <!--<i class="el-icon-check" style="color: green" /><span>{{ $t('account.connectedToFacebook') }}</span>-->
        <!--</div>-->
      <!--</div>-->
    </div>
  </el-card>
</template>

<script>
import PanThumb from '@/components/PanThumb';
import axios from 'axios';
import Resource from '@/api/resource';
import checkRole from '@/utils/role';

const userResource = new Resource('users');

export default {
  components: { PanThumb },
  props: {
    user: {
      type: Object,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          roles: [],
        };
      },
    },
  },
  data() {
    return {
      social: [
        {
          'name': 'Followers',
          'count': 1235,
        },
        {
          'name': 'Following',
          'count': 23512,
        },
        {
          'name': 'Friends',
          'count': 7242,
        },
      ],
    };
  },
  created() {
    this.$upload.on('file', {
      onSuccess(file, res) {
        this.loading = false;
        console.log(res.data.file_name);
        this.user.avatar = res.data.file_name;
        this.onSubmit();
      },
      onStart(res) {
        this.loading = true;
      },
      url: 'api/upload-avatar-image',
      name: 'file',
      body: this.uploadParameters,
      extensions: ['jpeg', 'jpg', 'png'],
      maxSizePerFile: 1024 * 1024 * 10,
      startOnSelect: true,
      http: function(data) {
        axios.post(data.url, data.body, { progress: data.progress }).then(data.success, data.error);
      },
    });
  },
  methods: {
    checkRole,
    getRole() {
      const roles = this.user.roles.map(value => this.$options.filters.uppercaseFirst(value));
      return roles.join(' | ');
    },
    facebook(){
      // window.open('/redirect')
      window.location.href = '/redirect';
    },
    onSubmit() {
      userResource
        .update(this.user.id, this.user)
        .then(response => {
          this.updating = false;

          this.$store.dispatch('user/setAvatar', response.data.avatar);

          this.$message({
            message: 'User avatar image updated successfully',
            type: 'success',
            duration: 5 * 1000,
          });
        })
        .catch(error => {
          console.log(error);
          this.updating = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.user-profile {
  .user-name {
    font-weight: bold;
  }
  .box-center {
    padding-top: 10px;
  }
  .user-role {
    padding-top: 10px;
    font-weight: 400;
    font-size: 14px;
  }
  .box-social {
    padding-top: 30px;
    .el-table {
      border-top: 1px solid #dfe6ec;
    }
  }
  .user-follow {
    padding-top: 20px;
  }

  .loginBtn {
    box-sizing: border-box;
    position: relative;
    /* width: 13em;  - apply for fixed size */
    margin: 0.2em;
    padding: 0 15px 0 46px;
    border: none;
    text-align: left;
    line-height: 34px;
    white-space: nowrap;
    border-radius: 0.2em;
    font-size: 16px;
    color: #FFF;
  }
  .loginBtn:before {
    content: "";
    box-sizing: border-box;
    position: absolute;
    top: 0;
    left: 0;
    width: 34px;
    height: 100%;
  }
  .loginBtn:focus {
    outline: none;
  }
  .loginBtn:active {
    box-shadow: inset 0 0 0 32px rgba(0,0,0,0.1);
  }

  /* Facebook */
  .loginBtn--facebook {
    background-color: #4C69BA;
    background-image: linear-gradient(#4C69BA, #3B55A0);
    /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
    text-shadow: 0 -1px 0 #354C8C;
  }
  .loginBtn--facebook:before {
    border-right: #364e92 1px solid;
    background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png') 6px 6px no-repeat;
  }
  .loginBtn--facebook:hover,
  .loginBtn--facebook:focus {
    background-color: #5B7BD5;
    background-image: linear-gradient(#5B7BD5, #4864B1);
  }
}
</style>

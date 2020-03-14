<template>
  <el-card v-if="name">
    <div class="user-profile">

      <div v-if="avatar" class="user-avatar box-center">
        <!--<pan-thumb :image="user.avatar" :height="'100px'" :width="'100px'" :hoverable="false" />-->

        <el-image

          style="width: 100px; height: 100px;border-radius: 4px;"
          :src="avatar"
        />
      </div>
      <div class="box-center">
        <div class="user-name text-center">
          {{ name }}
        </div>
        <div class="user-role text-center text-muted" style="margin-bottom: 15px">
          Zona Cluj
        </div>
        <div class="user-name text-center">
          <el-tag
            v-if="!volunteer"
            type="danger"
            effect="dark"
          >Neinregistrat</el-tag>
        </div>

        <el-tag
          v-if="volunteer"
          type="success"
          effect="dark"
        >Inregistrat</el-tag>
      </div>

      <div class="box-social">
        <el-table :data="volunteerList" :show-header="false">
          <el-table-column prop="name" label="Name" />
          <el-table-column prop="info" label="Info" align="left" />

        </el-table>
      </div>

      <div class="user-follow">
        <router-link to="/voluntari/inregistrare">
          <el-button type="primary" style="width: 100%;">
            {{ volunteer ? "Actualizare date" : "Inregistrare voluntar" }}
          </el-button>
        </router-link>
      </div>
    </div>
    </div>
  </el-card>
</template>

<script>

import { mapGetters } from 'vuex';

import checkRole from '@/utils/role';
import Resource from '@/api/resource';
const volunteersResource = new Resource('volunteers');

export default {
  components: { },

  data() {
    return {
      volunteer: '',
      volunteerList: [],
    };
  },
  computed: {
    ...mapGetters([
      'roles',
      'name',
      'avatar',
    ]),
  },
  mounted() {
    this.get();
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

    get(){
      volunteersResource
        .get(this.user_id)
        .then(response => {
          this.loading = false;

          if (response.volunteer){
            this.volunteer = response.volunteer;

            const mapFields = {
              name: 'Nume',
              email: 'Email',
              phone: 'Telefon',
              city: 'Oras',
              address: 'Adresa',
              neighborhood: 'Cartier',
              activation_area: 'Zona activare',
              involvement_type: 'Tip implicare',
              availability: 'Disponibilitate',
              availability_details: 'Detalii disponibilitate',
              observations: 'Observatii',
            };

            Object.entries(this.volunteer).forEach(entry => {
              const key = entry[0];
              const value = entry[1];
              if (mapFields[key]){
                this.volunteerList.push({
                  name: mapFields[key],
                  info: value,

                });
              }
            });
          }
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
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

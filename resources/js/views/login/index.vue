<template>
  <div class="login-container">
    <el-form
      ref="loginForm"
      :model="loginForm"
      :rules="loginRules"
      class="login-form"
      auto-complete="on"
      label-position="left"
    >
      <h3 class="title">Va ajutam din Satu Mare - Inscriere Voluntari</h3>
      <el-card>
        <div>
          <p>Version 5.0</p>
          <p>Salut! Ne bucurăm că ești aici și vrei să ajuți și tu împreună cu noi și îți mulțumim! Pentru a începe colaborarea, să ne prezentăm.</p>

          <p>
            <strong>Cum a apărut grupul?</strong>
          </p>
          <p>Acum mai mult ca oricând este nevoie de implicare și solidaritate. Odată cu trecerea României la scenariul 3 al crizei Coronavirus, am pornit în Satu Mare acest grup de solidaritate comunitară ”VĂ AJUTĂM DIN SATU MARE!”</p>

          <p>
            <strong>Cine face parte din grup?</strong>
          </p>
          <p>Suntem deja câteva zeci de voluntari, cetățeni activi, avem suportul tehnic și logistic a patru organizații clujene implicate civic: Vedem Just, Civic Suport, Clujul Sustenabil, la care s-a alăturat și Center for peace and Violence Prevention. Ne alăturăm astfel orașelor București, Cluj-Napoca, Sibiu, Arad și Constanța, care au pornit inițiative similare pentru a oferi sprijin cetățenilor și autorităților în gestionarea crizei.</p>

          <p>
            <strong>Ce ne propunem?</strong>
          </p>
          <p>Ne dorim un spațiu civic virtual în care să reunim sătmărenii pentru a trece cât mai bine de această perioadă de criză. Vrem să oferim sprijin pentru cei aflați în imposibilitatea de a se aproviziona pentru a reduce riscurile expunerii lor la virus. Vom ajuta persoane în vârstă, persoane cu afecțiuni specifice sau familii cu copii care nu trebuie sau nu pot să iasă din locuințe pentru cumpărături sau medicamente.</p>
          <p>Facem apel la responsabilitate și organizare civică pentru că împreună putem face mai mult.</p>

          <p>
            <strong>Cum facem asta?</strong>
          </p>
          <p>În primul rând prin organizarea eficientă a echipei de voluntari. Prioritatea noastră este asigurarea unei activități fără riscuri și cu respectarea tuturor normelor de siguranță indicate de autorități. În acest scop, am dezvoltat o procedură clară și detaliată prin care să menținem atât siguranța voluntarilor implicați cât și siguranța beneficiarilor. Voluntarii trec printr-un proces minuțios de selecție și instruire și își asumă respectarea întregii proceduri. Astfel știm toți că facem mai mult bine!</p>
          <p>Voluntarii trec printr-un proces minuțios de selecție și instruire și &icirc;și asumă respectarea &icirc;ntregii proceduri. Astfel știm toți că facem mai mult bine!</p>

          <p>
            <strong>Cum ne propunem să ajungem la grupul țintă?</strong>
          </p>
          <p>
            Am lansat un call center, care poate fi apelat la numărul
            <strong>0361.406.517</strong> pentru ca oricine să poată apela la noi. Promovăm intens acest număr.
          </p>
          <p>Încurajăm voluntarii și prietenii din grupul de Facebook ”Vă ajutăm din Satu Mare” să discute cu asociațiile de proprietari și să distribuie informații despre ajutorul pe care îl putem oferi.</p>
          <p>Există deja voluntari, împărțiți pe zone și căutăm în continuare să ne mărim echipa și capacitatea de livrare.</p>
          <p>"Vrem să ajutăm instituțiile statului în această perioadă de criză. O rețea de voluntari precum cea a noastră poate fi un suport pentru măsurile luate de Guvern, dacă e nevoie. Dar extrem de importantă este solidaritatea în comunitate, cea pe care o vom construi pentru a combate infecția.” declară Cristi Danileț, reprezentant al asociației VeDem Just.</p>

          <p>
            <strong>Unde ne găsești?</strong>
          </p>
          <p>Pentru a evita propagarea virusului, ne organizăm exclusiv online, pe rețelele de socializare.</p>
          <p>Oricine e dispus să se implice și să ajute poate găsi o formă potrivită pe www.ajutamsm.ro.</p>
          <p>Încurajează-ți prietenii să ni se alăture!</p>
          <p>Îți mulțumim pentru solidaritate!</p>
          <p>
            <string>Hai sa incepem!</string>
          </p>
        </div>
        <div class="links">
          <el-button
            :loading="loading"
            type="button"
            class="loginBtn loginBtn--facebook"
            @click="loginWithFacebook"
          >Login or Register cu Facebook</el-button>

          <el-button
            :loading="loading"
            type="button"
            class="loginBtn loginBtn--google"
            @click="loginWithGoogle"
          >Login or Register cu Google</el-button>

          <!--<el-button @click="handleLogin()">Login</el-button>-->
        </div>
      </el-card>
    </el-form>
  </div>
</template>

<script>
import LangSelect from '@/components/LangSelect';
import { validEmail } from '@/utils/validate';

export default {
  name: 'Login',
  components: { LangSelect },
  data() {
    const validateEmail = (rule, value, callback) => {
      if (!validEmail(value)) {
        callback(new Error('Please enter the correct email'));
      } else {
        callback();
      }
    };
    const validatePass = (rule, value, callback) => {
      if (value.length < 4) {
        callback(new Error('Password cannot be less than 4 digits'));
      } else {
        callback();
      }
    };
    return {
      loginForm: {
        email: '',
        password: '',
      },
      loginRules: {
        email: [{ required: true, trigger: 'blur', validator: validateEmail }],
        password: [
          { required: true, trigger: 'blur', validator: validatePass },
        ],
      },
      loading: false,
      pwdType: 'password',
      redirect: undefined,
    };
  },
  created() {
    if (location.protocol !== 'https:') {
      console.log("HTTPS redirect");
      location.replace(
        `https:${location.href.substring(location.protocol.length)}`
      );
    }
  },
  watch: {
    $route: {
      handler: function(route) {
        this.redirect = route.query && route.query.redirect;
      },
      immediate: true,
    },
  },
  methods: {
    showPwd() {
      if (this.pwdType === 'password') {
        this.pwdType = '';
      } else {
        this.pwdType = 'password';
      }
    },
    handleLogin() {
      // this.$refs.loginForm.validate(valid => {
      //   if (valid) {
      this.loading = true;
      this.$store
        .dispatch('user/login', this.loginForm)
        .then(() => {
          this.$router.push({ path: this.redirect || '/' });
          this.loading = false;
        })
        .catch(() => {
          this.loading = false;
        });
      //   } else {
      //     console.log('error submit!!');
      //     return false;
      //   }
      // });
    },
    AuthProvider(provider) {
      var self = this;
      this.loading = true;
      this.$auth
        .authenticate(provider)
        .then(response => {
          self.SocialLogin(provider, response);
        })
        .catch(err => {
          console.log({ err: err });
          this.loading = false;
        });
    },
    SocialLogin(provider, response) {
      this.$store
        .dispatch('user/loginWithSocialNetworks', {
          provider: provider,
          data: response,
        })
        .then(resp => {
          if (resp.roles.includes('user') && !resp.volunteer) {
            this.$router.push({ path: '/voluntari/inregistrare' });
          } else if (resp.roles.includes('user') && resp.volunteer) {
            if (!resp.volunteer.data_acord) {
              this.$router.push({
                path: '/voluntari/inregistrare?semneaza=true',
              });
            } else {
              this.$router.push({ path: this.redirect || '/' });
            }
          } else {
            this.$router.push({ path: this.redirect || '/' });
          }

          this.loading = false;
        })
        .catch(() => {
          this.loading = false;
        });
    },

    loginWithFacebook() {
      this.loading = true;
      FB.getLoginStatus(response => {
        console.log(response);
        if (response.status === 'connected') {
          this.SocialLogin('facebook', {
            token: response.authResponse.accessToken,
          });
        } else {
          FB.login(
            response => {
              if (response.status === 'connected') {
                this.SocialLogin('facebook', {
                  token: response.authResponse.accessToken,
                });
              }
            },
            { scope: 'public_profile,email' }
          );
        }
      });
    },

    loginWithGoogle() {
      this.$gAuth
        .getAuthCode()
        .then(authCode => {
          // on success
          return this.SocialLogin('google', { code: authCode });
        })
        .then(response => {
          // after ajax
        })
        .catch(error => {
          // on fail do something
        });
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss">
$bg: #2d3a4b;
$light_gray: #eee;

/* reset element-ui css */
.login-container {
  .el-input {
    display: inline-block;
    height: 47px;
    width: 85%;
    input {
      background: transparent;
      border: 0px;
      -webkit-appearance: none;
      border-radius: 0px;
      padding: 12px 5px 12px 15px;
      color: $light_gray;
      height: 47px;
      &:-webkit-autofill {
        -webkit-box-shadow: 0 0 0px 1000px $bg inset !important;
        -webkit-text-fill-color: #fff !important;
      }
    }
  }
  .el-form-item {
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    color: #454545;
  }
}
</style>

<style rel="stylesheet/scss" lang="scss" >
body {
  background: #2d3a4b;
}
</style>

<style rel="stylesheet/scss" lang="scss" scoped>
$bg: #2d3a4b;
$dark_gray: #889aa4;
$light_gray: #eee;

.login-container {
  height: 100%;
  width: 100%;
  background-color: $bg;
  .login-form {
    position: absolute;
    left: 0;
    right: 0;
    width: 750px;
    max-width: 100%;
    padding: 35px 35px 15px 35px;
    margin: 120px auto;
  }
  .tips {
    font-size: 14px;
    color: #fff;
    margin-bottom: 10px;
    span {
      &:first-of-type {
        margin-right: 16px;
      }
    }
  }
  .svg-container {
    padding: 6px 5px 6px 15px;
    color: $dark_gray;
    vertical-align: middle;
    width: 30px;
    display: inline-block;
  }
  .title {
    font-size: 26px;
    font-weight: 400;
    color: $light_gray;
    margin: 0px auto 40px auto;
    text-align: center;
    font-weight: bold;
  }
  .show-pwd {
    position: absolute;
    right: 10px;
    top: 7px;
    font-size: 16px;
    color: $dark_gray;
    cursor: pointer;
    user-select: none;
  }
  .set-language {
    color: #fff;
    position: absolute;
    top: 40px;
    right: 35px;
  }

  /* Shared */
  .loginBtn {
    box-sizing: border-box;
    position: relative;
    /* width: 13em;  - apply for fixed size */
    margin: 0.2em;
    padding: 0 15px 0 46px;
    border: none;

    line-height: 34px;
    white-space: nowrap;
    border-radius: 0.2em;
    font-size: 16px;
    color: #fff;
    width: 100%;
    text-align: center;
  }
  .loginBtn:before {
    content: '';
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
    box-shadow: inset 0 0 0 32px rgba(0, 0, 0, 0.1);
  }

  /* Facebook */
  .loginBtn--facebook {
    background-color: #4c69ba;
    background-image: linear-gradient(#4c69ba, #3b55a0);
    /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
    text-shadow: 0 -1px 0 #354c8c;
  }
  .loginBtn--facebook:before {
    border-right: #364e92 1px solid;
    background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png')
      6px 6px no-repeat;
  }
  .loginBtn--facebook:hover,
  .loginBtn--facebook:focus {
    background-color: #5b7bd5;
    background-image: linear-gradient(#5b7bd5, #4864b1);
  }

  /* Google */
  .loginBtn--google {
    /*font-family: "Roboto", Roboto, arial, sans-serif;*/
    background: #dd4b39;
  }
  .loginBtn--google:before {
    border-right: #bb3f30 1px solid;
    background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_google.png')
      6px 6px no-repeat;
  }
  .loginBtn--google:hover,
  .loginBtn--google:focus {
    background: #e74b37;
  }
}
</style>

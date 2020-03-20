<template>
  <div class="login-container">
    <el-form ref="loginForm" :model="loginForm" :rules="loginRules" class="login-form" auto-complete="on" label-position="left">
      <h3 class="title">
        Va ajutam din Cluj - Inscriere Voluntari
      </h3>
      <el-card>
        <p>&Icirc;n vremuri de criză e nevoie de implicare și solidaritate! Odată cu trecerea țării la scenariul 3 al crizei Corona Virus, s-a format &icirc;n mun. Cluj-Napoca grupul de solidaritate comunitară &ldquo;VĂ AJUTĂM DIN CLUJ!&rdquo;. Grupul are &icirc;n prezent 450 de membri și reunește mai mulți cetățeni activi, sub coordonarea a trei organizații implicate civic din Cluj: Vedem Just, Civic Suport și Clujul Sustenabil. Astfel, Clujul se alătură orașelor București, Sibiu, Arad și Constanța care au pornit inițiative similare pentru a sprijini cetățenii și autoritățile &icirc;n gestionarea situației generate de Corona Virus.</p>
        <p><strong>Unde găsiți acest grup?</strong><br>Pentru a evita propagarea virusului, grupul se organizează pe rețelele de socializare și exclusiv online.</p>
        <p><strong>Ce &icirc;și propune?</strong><br>Loc civic de &icirc;nt&acirc;lnire pentru clujeni pe tema Coronavirus, dar mai ales grup de sprijin pentru cei aflați &icirc;n imposibilitatea de a se aproviziona &icirc;n perioada următoare. De asemenea este un apel la responsabilitate și organizare civică.</p>
        <p>Principalul obiectiv al lor este să organizeze eficient voluntari care să poată ajuta &icirc;n perioada critică oameni &icirc;n v&acirc;rstă, persoane cu afecțiuni specifice ori familii cu copii care nu trebuie sau nu pot să iasă din locuințe pentru cumpărături sau medicamente. Va fi organizat un program de livrări la domiciliu, care să respecte aceste nevoi speciale și care să mențină siguranța at&acirc;t a voluntarilor implicați, c&acirc;t și a beneficiarilor.</p>
        <p>&ldquo;Cumparaturile vor fi plătite de solicitanți și se vor face &icirc;n mare parte prin colaborarea cu c&acirc;țiva furnizori din lanțul retail.&rdquo;- spune Cami Gui, voluntar care asigură contactul cu retailerii din partea organizației Clujul Sustenabil.</p>
        <p>&ldquo;Pe l&acirc;ngă activitatea de aprovizionare, ne așteptăm să apară &icirc;n timp și alte tipuri de nevoi, pentru care ne pregătim deja: procurarea și distribuția de echipamente de protectie, monitorizarea datelor persoanelor &icirc;n carantină, discuții specifice cu autoritățile și ajutor oferit lor la cerere, chiar și o linie de consultații pe partea de anxietate și gestionarea stresului pentru medici. Știm de c&acirc;teva planuri de sprijin existente ale altor organizații, cum ar fi CERT și Beard Brothers și intenționăm să comunicăm constant și să ne ajutăm reciproc &icirc;n trecerea cu bine a acestei crize&rdquo;. Ligia Măhălean, una din persoanele care au avut inițiativa constituirii acestui grup.</p>
        <p><strong>Cum &icirc;și propun să ajungă la v&acirc;rstnici și alte persoane imobilizate sau izolate la domiciliu?</strong><br>Voluntarii din grup vor discuta cu asociațiile de proprietari și vor distribui informații despre ajutorul pe care ei &icirc;l pot oferi persoanelor din categoriile menționate mai sus. Vor fi responsabili pe zone și vor să comunica cu cei aflați &icirc;n nevoie, din zona lor.</p>
        <p>Asigurarea unei activități fără riscuri și cu respectarea tuturor normelor de siguranță indicate de autorități se va face cu ajutorul Crucii Roșii și fiecare voluntar va trece printr-un instructaj specific.</p>
        <p><strong>Cum &icirc;și propun să gestioneze relația cu autoritățile?</strong><br>Grupul civic VĂ AJUTĂM DIN CLUJ face un apel de comunicare și colaborare către Direcția de Sănătate Publică, Prefectură, Primărie, Consiliul Județean, Inspectoratul pentru Situații de Urgență. Ei &icirc;și vor pune la dispoziție resursele de timp, implicare, cunoștințe, mașinile și disponibilitatea de a le folosi &icirc;n sprijinul comunității.<br>&ldquo;Vrem să ajutăm instituțiile statului &icirc;n această perioadă de criză. O rețea de voluntari precum cea a noastră poate fi un suport pentru măsurile luate de Guvern dacă e nevoie. Dar extrem de importantă este solidaritatea &icirc;n comunitate pe care o vom construi pentru a combate infecția.&rdquo; declară Cristi Danileț, reprezentant al asociației VeDem Just.</p>
        <p><br>Oricine este dispus să se implice și să ajute, o poate face pe Facebook &icirc;n grupul &rdquo;Vă ajutăm din Cluj!&rdquo;:&nbsp;
          <br>
          <a
            style="    word-break: break-all;
    margin-top: 10px;
    color: blue;"
            href="https://www.facebook.com/groups/2550667518542414/"
          >https://www.facebook.com/groups/2550667518542414/</a>&nbsp;</p>

        <div class="links">
          <el-button :loading="loading" type="button" class="loginBtn loginBtn--facebook" @click="loginWithFacebook">
            Login or Register cu Facebook
          </el-button>

          <el-button :loading="loading" type="button" class="loginBtn loginBtn--google" @click="loginWithGoogle">
            Login or Register cu Google
          </el-button>

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
        password: [{ required: true, trigger: 'blur', validator: validatePass }],
      },
      loading: false,
      pwdType: 'password',
      redirect: undefined,
    };
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
      this.$store.dispatch('user/login', this.loginForm)
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
      this.$auth.authenticate(provider).then(response => {
        self.SocialLogin(provider, response);
      }).catch(err => {
        console.log({ err: err });
        this.loading = false;
      });
    },
    SocialLogin(provider, response){
      this.$store.dispatch('user/loginWithSocialNetworks', { provider: provider, data: response })
        .then((resp) => {
          if (resp.roles.includes('user') && !resp.volunteer){
            this.$router.push({ path: '/voluntari/inregistrare' });
          } else {
            if (!resp.volunteer.data_acord){
                this.$router.push({ path: '/voluntari/inregistrare?semneaza=true' });
            } else {
              this.$router.push({ path: this.redirect || '/' });
            }
          }

          this.loading = false;
        })
        .catch(() => {
          this.loading = false;
        });
    },

    loginWithFacebook(){
      this.loading = true;
      FB.getLoginStatus((response) => {
        console.log(response);
        if (response.status === 'connected'){
          this.SocialLogin('facebook', { token: response.authResponse.accessToken });
        } else {
          FB.login((response) => {
            if (response.status === 'connected'){
              this.SocialLogin('facebook', { token: response.authResponse.accessToken });
            }
          }, { scope: 'public_profile,email' });
        }
      });
    },

    loginWithGoogle(){
      this.$gAuth.getAuthCode()
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
$bg:#2d3a4b;
$light_gray:#eee;

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
  body{
    background: #2d3a4b;
  }
  </style>

<style rel="stylesheet/scss" lang="scss" scoped>
$bg:#2d3a4b;
$dark_gray:#889aa4;
$light_gray:#eee;

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
    color: #FFF;
    width: 100%;
    text-align: center;
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

  /* Google */
  .loginBtn--google {
    /*font-family: "Roboto", Roboto, arial, sans-serif;*/
    background: #DD4B39;
  }
  .loginBtn--google:before {
    border-right: #BB3F30 1px solid;
    background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_google.png') 6px 6px no-repeat;
  }
  .loginBtn--google:hover,
  .loginBtn--google:focus {
    background: #E74B37;
  }
}
</style>

<template>
  <div>
    <div class="filter-container">
      <el-input v-model="query.keyword" placeholder="Nume, email, telefon, adresa" style="width: 250px;" class="filter-item" @keyup.enter.native="handleFilter" />

      <el-select v-model="query.involvement_direction" clearable placeholder="Directie Implicare" class="filter-item" @change="handleFilter">
        <el-option label="Call Center" value="Call Center" />
        <el-option label="Medicamente" value="Medicamente" />
        <el-option label="Alimente" value="Alimente" />
      </el-select>

      <el-select v-model="query.county" filterable clearable placeholder="Judet" class="filter-item" @change="handleFilter">
        <el-option v-for="judet in judete" :key="judet.auto" :label="judet.nume" :value="judet.auto" />
      </el-select>

      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        {{ $t('table.search') }}
      </el-button>
    </div>

    <div class="table-container">
      <el-table v-loading="loading" :data="list" border fit highlight-current-row style="width: 100%">
        <el-table-column align="center" label="ID" width="80">
          <template slot-scope="scope">
            <span>{{ scope.row.index }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Nume">
          <template slot-scope="scope">
            <span>{{ scope.row.name }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Email">
          <template slot-scope="scope">
            <span>{{ scope.row.email }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Telefon">
          <template slot-scope="scope">
            <span>{{ scope.row.phone }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Judet">
          <template slot-scope="scope">
            <span>{{ scope.row.county }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Localitate">
          <template slot-scope="scope">
            <span>{{ scope.row.city }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Adresa">
          <template slot-scope="scope">
            <span>{{ scope.row.address }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Cartier">
          <template slot-scope="scope">
            <span>{{ scope.row.neighborhood }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Zona unde doresti sa devii activ">
          <template slot-scope="scope">
            <span>{{ scope.row.activation_area }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Tip Implicare">
          <template slot-scope="scope">
            <span>{{ scope.row.involvement_type }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Directie Implicare">
          <template slot-scope="scope">
            <span>{{ scope.row.involvement_direction }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Disponibilitate">
          <template slot-scope="scope">
            <span>{{ scope.row.availability }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Observertii">
          <template slot-scope="scope">
            <span>{{ scope.row.observations }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Actions" width="150">
          <template slot-scope="scope">
            <el-button v-role="['admin', 'coordonator']" type="primary" size="small" icon="el-icon-edit" @click="editVolunteerDialog(scope.row)">
              Edit
            </el-button>
          </template>
        </el-table-column>
      </el-table>

      <pagination v-show="total>0" :total="total" :page.sync="query.page" :limit.sync="query.limit" @pagination="getList" />
    </div>

    <el-dialog
      title="Date Voluntar"
      :visible.sync="dialogVisible"
      width="60%"
    >

      <el-form ref="update" :model="volunteerModel" label-width="120px" label-position="top" :rules="loginRules" auto-complete="on">
        <el-form-item label="Nume Complet" prop="name">
          <el-input v-model="volunteerModel.name" />
        </el-form-item>

        <el-form-item label="Email" prop="email">
          <el-input v-model="volunteerModel.email" />
        </el-form-item>

        <el-form-item label="Phone" prop="phone">
          <el-input v-model="volunteerModel.phone" />
        </el-form-item>

        <el-form-item label="Judet" prop="county">
          <el-select v-model="volunteerModel.county" filterable placeholder="Selecteaza judetul" @change="getOraseJudet">
            <el-option v-for="judet in judete" :key="judet.auto" :label="judet.nume" :value="judet.auto" />
          </el-select>
        </el-form-item>

        <el-form-item label="Oras" prop="city">
          <el-select v-model="volunteerModel.city" filterable placeholder="Selecteaza orasul">
            <el-option v-for="(oras,index) in orase" :key="oras.nume+'-oras'+index" :label="oras.nume" :value="oras.nume" />
          </el-select>
        </el-form-item>

        <el-form-item label="Adresa Completa" prop="address">
          <el-input v-model="volunteerModel.address" />
        </el-form-item>

        <el-form-item label="Cartier" prop="neighborhood">
          <el-select v-model="volunteerModel.neighborhood" placeholder="Selecteaza cartierul">
            <el-option label="Andrei Mureșanu" value="Andrei Mureșanu" />
            <el-option label="Bulgaria" value="Bulgaria" />
            <el-option label="Bună Ziua" value="Bună Ziua" />
            <el-option label="Centru" value="Centru" />
            <el-option label="Dâmbul Rotund" value="Dâmbul Rotund" />
            <el-option label="Gara" value="Gara" />
            <el-option label="Gheorgheni" value="Gheorgheni" />
            <el-option label="Grădini Mănăștur" value="Grădini Mănăștur" />
            <el-option label="Plopilor" value="Plopilor" />
            <el-option label="Grigorescu" value="Grigorescu" />
            <el-option label="Gruia" value="Gruia" />
            <el-option label="Iris" value="Iris" />
            <el-option label="Între Lacuri" value="Între Lacuri" />
            <el-option label="Mănăștur" value="Mănăștur" />
            <el-option label="Mărăști" value="Mărăști" />
            <el-option label="Someșeni" value="Someșeni" />
            <el-option label="Zorilor" value="Zorilor" />
            <el-option label="Sopor" value="Sopor" />
            <el-option label="Borhanci" value="Borhanci" />
            <el-option label="Becaș" value="Becaș" />
            <el-option label="Făget" value="Făget" />
            <el-option label="Lomb" value="Lomb" />
            <el-option label="Tineretului" value="Tineretului" />
            <el-option label="Pata-Rât" value="Pata-Rât" />
          </el-select>
        </el-form-item>

        <el-form-item label="Zona unde doresti sa devii activ" prop="activation_area">
          <el-input v-model="volunteerModel.activation_area" />
        </el-form-item>

        <el-form-item label="Tip Implicare" prop="involvement_type">
          <el-select v-model="volunteerModel.involvement_type" placeholder="Tipul de Implicare">
            <el-option label="Promoter - va promova informațiile și campania, dar nu este implicat direct in activitatea noastra" value="Promoter" />
            <el-option label="Susținător - ajuta cu sarcini care nu implica posibilitatea contactului cu persoane bolnave" value="Susținător" />
            <el-option label="Voluntar - ajuta la distribuirea de pachete cu alimente către persoanele bolnave" value="Voluntar" />
          </el-select>
        </el-form-item>

        <el-form-item label="Directie Implicare" prop="involvement_direction">
          <el-select v-model="volunteerModel.involvement_direction" placeholder="Directie Implicare">
            <el-option label="Call Center" value="Call Center" />
            <el-option label="Medicamente" value="Medicamente" />
            <el-option label="Alimente" value="Alimente" />
          </el-select>
        </el-form-item>

        <el-form-item label="Disponibilitate" prop="availability">
          <el-select v-model="volunteerModel.availability" placeholder="Selecteaza disponibilitatea">
            <el-option label="Zilnica" value="Zilnica" />
            <el-option label="Saptamanala" value="Saptamanala" />
          </el-select>
        </el-form-item>

        <el-form-item :label="volunteerModel.availability ==='Zilnica' ? 'In ce interval orar puteti ?' : 'Cate ore pe saptamana?'" prop="availability_details">
          <el-input v-model="volunteerModel.availability_details" />
        </el-form-item>

        <el-form-item label="Observatii">
          <el-input v-model="volunteerModel.observations" type="textarea" />
        </el-form-item>

      </el-form>

      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">Cancel</el-button>
        <el-button type="primary" :loading="loadingButton" @click="updateVolunteer(volunteerModel)">Save</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';

import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import waves from '@/directive/waves'; // Waves directive
import permission from '@/directive/permission'; // Permission directive

import role from '@/directive/role'; // Permission directive (v-role)
import { mapGetters } from 'vuex';
import { validEmail } from '@/utils/validate';
import axios from 'axios';
const volunteersResource = new Resource('volunteers');
export default {
  name: 'ListaVoluntari',
  components: { Pagination },
  directives: { waves, permission, role },
  data(){
    const validateEmail = (rule, value, callback) => {
      if (!validEmail(value)) {
        callback(new Error('Please enter the correct email'));
      } else {
        callback();
      }
    };
    return {
      dialogVisible: false,
      list: [],
      loading: false,
      total: 0,
      query: {
        page: 1,
        limit: 15,
        keyword: '',
        categories: '',
        status: '',
      },
      volunteerModel: '',
      loadingButton: false,
      judete: [],
      orase: [],
      loginRules: {
        email: [{ required: true, trigger: 'blur', message: 'Adresa de email nu este corecta', validator: validateEmail }],
        name: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        phone: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        city: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        address: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        neighborhood: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        activation_area: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        involvement_type: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        involvement_direction: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        availability: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        availability_details: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
      },
    };
  },
  computed: {
    ...mapGetters([
      'roles',
    ]),
  },
  mounted(){
    this.getList();

    axios.get('https://roloca.coldfuse.io/judete').then(resp => {
      this.judete = resp.data;
    });
  },
  methods: {
    editVolunteerDialog(volunteer){
      this.volunteerModel = volunteer;

      this.getOraseJudet();

      this.dialogVisible = true;
    },
    handleClose(done) {
      this.dialogVisible = false;
    },
    async getList() {
      const { limit, page } = this.query;
      this.loading = true;
      const { data, meta } = await
      volunteersResource.list(this.query);
      this.list = data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = meta.total;
      this.loading = false;
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
    updateVolunteer(volunteer){
      this.form = volunteer;

      volunteersResource
        .update(this.form.id, this.form)
        .then(response => {
          this.$message({
            message: 'Datele au fost actualizate',
            type: 'success',
            duration: 5 * 1000,
          });
          this.loading = false;
          this.$store.dispatch('user/getInfo');
          this.$router.push('/voluntari/list');
          this.dialogVisible = false;
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    getOraseJudet(){
      axios.get('https://roloca.coldfuse.io/orase/' + this.volunteerModel.county).then(resp => {
        this.orase = resp.data;
      });
    },
  },
};
</script>

<style scoped>
  .el-form-item__label{
    margin-bottom: -20px;
  }
  .filter-container, .table-container {
    padding: 10px;
  }

  .el-table .cell{
    word-break: break-word;
  }
</style>

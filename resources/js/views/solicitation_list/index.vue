<template>
  <div>
    <div v-if="!volunteer " v-role="['user']" style="text-align: center">
      <h4>Pentru a putea prelua o solicitare trebuie sa completezi formularul de inregistrare.</h4>
      <div class="user-follow">
        <router-link to="/voluntari/inregistrare">
          <el-button type="primary">
            {{ volunteer ? "Actualizare date" : "Inregistrare voluntar" }}
          </el-button>
        </router-link>
      </div>
    </div>

    <div v-if="volunteer && roles[0] === 'user' || roles[0] === 'admin'" class="filter-container">
      <el-input v-model="query.keyword" placeholder="Cuvinte cheie" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />

      <el-select v-model="query.categories" placeholder="Categorie" clearable style="width: 150px" class="filter-item" @change="handleFilter">
        <el-option label="Alimente" value="alimente" />
        <el-option label="Medicamente" value="medicamente" />
        <el-option label="Personalizat" value="personalizat" />
      </el-select>

      <el-select v-model="query.status" v-permission="['manage user']" placeholder="Status" clearable style="width: 250px" class="filter-item" @change="handleFilter">
        <el-option label="In Triaj" value="triaj" />
        <el-option label="Necesita voluntar" value="necesita_voluntar" />
        <el-option label="In proces de solutionare" value="solutionare" />
        <el-option label="Finalizat" value="finalizat" />
        <el-option label="Respins" value="respins" />

      </el-select>
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        Cauta
      </el-button>
    </div>

    <div v-if="volunteer && roles[0] === 'user' || roles[0] === 'admin'" class="table-container">
      <el-table v-loading="loading" :data="list" border fit highlight-current-row style="width: 100%">
        <el-table-column align="center" label="ID" width="80">
          <template slot-scope="scope">
            <span>{{ scope.row.index }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Nume">
          <template slot-scope="scope">
            <span>{{ scope.row.name }} {{ scope.row.last_name }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Telefon">
          <template slot-scope="scope">
            <span>{{ scope.row.phone }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Adresa">
          <template slot-scope="scope">
            <span>{{ scope.row.address }}, {{ scope.row.neighborhood }}, {{ scope.row.city }}, {{ scope.row.county }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Categorie" width="150">
          <template slot-scope="scope">
            <span>{{ scope.row.categories | uppercaseFirst }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Status" width="180">
          <template slot-scope="scope">
            <el-tag v-if="scope.row.status==='finalizat'" type="success">Finalizat</el-tag>
            <el-tag v-if="scope.row.status==='triaj'">In Triaj</el-tag>
            <el-tag v-if="scope.row.status==='solutionare'" type="info">In proces de solutionare</el-tag>
            <el-tag v-if="scope.row.status==='necesita_voluntar'" type="warning">Necesita voluntar</el-tag>
            <el-tag v-if="scope.row.status==='respins'" type="danger">Respins</el-tag>

            <span v-if="scope.row.status==='solutionare' && scope.row.volunteer"> {{ scope.row.volunteer.name }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Actiuni" width="370">
          <template slot-scope="scope">

            <el-button v-if="!scope.row.volunteer_id" v-role="['user']" type="primary" size="mini" icon="el-icon-document-checked" @click="preluareDialog(scope.row)">
              Preia solicitarea
            </el-button>

            <el-button v-if="scope.row.volunteer_id" v-role="['user']" type="warning" size="mini" icon="el-icon-edit" @click="raspunsuriFormularDialog(scope.row)">
              Raspunsuri formular
            </el-button>

            <el-button v-if="scope.row.volunteer_id" v-role="['user']" type="danger" size="mini" icon="el-icon-s-release" @click="handleRenunta(scope.row.id, scope.row.name);">
              Renunta
            </el-button>

            <el-popover
              placement="top-start"
              title=""
              width="200"
              trigger="hover"
              content="Solutioneaza solicitarea."
            >
              <el-button v-if="scope.row.volunteer_id" slot="reference" v-role="['user']" type="success" icon="el-icon-check" size="mini" circle @click="solutioneaza(scope.row)" />

            </el-popover>

            <el-button v-permission="['manage user']" type="primary" size="mini" icon="el-icon-edit" @click="editDialog(scope.row)">
              Edit
            </el-button>

            <el-button v-permission="['manage user']" type="warning" size="mini" icon="el-icon-edit" @click="raspunsuriFormularDialog(scope.row)">
              Raspunsuri formular
            </el-button>

            <el-button v-permission="['manage user']" type="danger" size="mini" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.name);">
              Delete
            </el-button>

          </template>
        </el-table-column>
      </el-table>

      <pagination v-show="total>0" :total="total" :page.sync="query.page" :limit.sync="query.limit" @pagination="getList" />

    </div>

    <el-dialog
      title="Editeaza solicitarea"
      :visible.sync="dialogVisible"
      width="30%"
      :before-close="handleClose"
    >

      <el-form ref="form" :model="solicitareModel" label-width="120px" label-position="left">

        <el-form-item label="Nume">
          <el-input v-model="solicitareModel.name" />
        </el-form-item>

        <el-form-item label="Prenume">
          <el-input v-model="solicitareModel.last_name" />
        </el-form-item>

        <el-form-item label="Telefon">
          <el-input v-model="solicitareModel.phone" />
        </el-form-item>

        <el-form-item label="Strada">
          <el-input v-model="solicitareModel.address" />
        </el-form-item>

        <el-form-item label="Cartier">
          <el-input v-model="solicitareModel.neighborhood" />
        </el-form-item>

        <el-form-item label="Oras">
          <el-input v-model="solicitareModel.city" />
        </el-form-item>

        <el-form-item label="Judet">
          <el-input v-model="solicitareModel.county" />
        </el-form-item>

        <el-form-item label="Status">
          <el-select v-model="solicitareModel.status" placeholder="Status" clearable style="width: 250px" class="filter-item">
            <el-option label="In Triaj" value="triaj" />
            <el-option label="Necesita voluntar" value="necesita_voluntar" />
            <el-option label="In proces de solutionare" value="solutionare" />
            <el-option label="Finalizat" value="finalizat" />
            <el-option label="Respins" value="respins" />

          </el-select>
        </el-form-item>

      </el-form>

      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">Cancel</el-button>
        <el-button type="primary" :loading="loadingButton" @click="updateSolicitation('update')">Salveaza</el-button>
      </span>
    </el-dialog>

    <el-dialog
      title="Raspunsuri formular"
      :visible.sync="dialogRasp"
      width="40%"
    >

      <el-form ref="form" :model="solicitareModel" label-width="120px" label-position="top">

        <template v-for="item in solicitareModel.additional_responses">
          <div class="text item" style="font-weight: bold">
            {{ item.label }}
          </div>

          <div class="text item" style="margin-bottom: 20px">
            <span>{{ item.answer }}</span>

          </div>
        </template>

      </el-form>

      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogRasp = false">Cancel</el-button>
        <!--<el-button type="primary" @click="updateSolicitation()" :loading="loadingButton">Salveaza</el-button>-->
      </span>
    </el-dialog>

    <el-dialog
      title="Preia solicitarea"
      :visible.sync="dialogPreluare"
      width="60%"
    >
      <el-row :gutter="21">
        <el-col :span="15">

          <template v-for="item in solicitareModel.additional_responses">
            <div class="text item" style="font-weight: bold">
              {{ item.label }}
            </div>

            <div class="text item" style="margin-bottom: 20px">
              <span>{{ item.answer }}</span>

            </div>
          </template>

        </el-col>
        <el-col :span="9">
          <el-form ref="form" :model="solicitareModel" label-width="120px" label-position="top">

            <el-form-item label="Observatii">
              <el-input v-model="solicitareModel.observations" type="textarea" :autosize="{ minRows: 4, maxRows: 6}" />
            </el-form-item>
          </el-form>

        </el-col>
      </el-row>

      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogPreluare = false">Cancel</el-button>
        <el-button type="primary" :loading="loadingButton" @click="updateSolicitation('preluare')">Preia</el-button>
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
import checkPermission from '@/utils/permission'; // Permission checking
import { mapGetters } from 'vuex';
const solicitationsResource = new Resource('solicitations');
export default {
  name: 'SolicitationList',
  components: { Pagination },
  directives: { waves, permission, role },
  data(){
    return {
      dialogVisible: false,
      dialogRasp: false,
      dialogPreluare: false,
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
      solicitareModel: '',
      loadingButton: false,
    };
  },
  computed: {
    ...mapGetters([
      'volunteer',
      'roles',

    ]),

  },

  mounted(){
    this.getList();
  },
  methods: {

    editDialog(solicitare){
      this.solicitareModel = solicitare;
      this.dialogVisible = true;
    },
    raspunsuriFormularDialog(solicitare){
      this.solicitareModel = solicitare;
      this.dialogRasp = true;
    },
    preluareDialog(solicitare){
      this.solicitareModel = solicitare;
      this.dialogPreluare = true;
    },
    handleClose(done) {
      this.dialogVisible = false;
    },
    solutioneaza(solicitare){
      this.loadingButton = true;

      solicitationsResource
        .update(solicitare.id, { solicitation: solicitare, action: 'solutioneaza' })
        .then(response => {
          this.loadingButton = false;

          this.$message({
            message: 'Solicitarea a fost solutionata cu secces',
            type: 'success',
            duration: 5 * 1000,
          });

          this.handleFilter();
        })
        .catch(error => {
          console.log(error);
          this.loadingButton = false;
        });
    },
    updateSolicitation(action){
      this.loadingButton = true;

      solicitationsResource
        .update(this.solicitareModel.id, { solicitation: this.solicitareModel, action: action })
        .then(response => {
          this.loadingButton = false;

          if (action === 'preluare'){
            this.$message({
              message: 'Solicitare preluata cu succes',
              type: 'success',
              duration: 5 * 1000,
            });
          } else {
            this.$message({
              message: 'Solicitare actualizata cu succes',
              type: 'success',
              duration: 5 * 1000,
            });
          }

          this.dialogVisible = false;
          this.dialogPreluare = false;
          this.handleFilter();
        })
        .catch(error => {
          console.log(error);
          this.loadingButton = false;
        });
    },

    async getList() {
      const { limit, page } = this.query;
      this.loading = true;
      const { data, meta } = await
      solicitationsResource.list(this.query);
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
    handleRenunta(id, name){
      this.$confirm('Esti sigur ca vrei sa renunti la solicitare pentru ' + name + '?', 'Warning', {
        confirmButtonText: 'Da, vreau',
        cancelButtonText: 'Anuleaza',
        type: 'warning',
      }).then(() => {
        solicitationsResource.update(id, { solicitation: this.solicitareModel, action: 'renunta' }).then(response => {
          this.$message({
            type: 'success',
            message: 'Solicitare stearsa',
          });
          this.handleFilter();
        }).catch(error => {
          console.log(error);
        });
      }).catch(() => {
        // this.$message({
        //     type: 'info',
        //     message: 'Delete canceled',
        // });
      });
    },
    handleDelete(id, name) {
      this.$confirm('O sa stergi permanent cererea pentru ' + name + '. Esti sigur ca doresti sa stergi?', 'Warning', {
        confirmButtonText: 'Da, sterge',
        cancelButtonText: 'Anuleaza',
        type: 'warning',
      }).then(() => {
        solicitationsResource.destroy(id).then(response => {
          this.$message({
            type: 'success',
            message: 'Solicitare stearsa',
          });
          this.handleFilter();
        }).catch(error => {
          console.log(error);
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled',
        });
      });
    },
  },
};
</script>

<style scoped>
  .el-form-item__label{
    margin-bottom: -20px;
  }
  .filter-container {

    padding: 10px;
  }

  .table-container {

    padding: 10px;

  }

</style>

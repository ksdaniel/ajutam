<template>
  <div>
    <div class="filter-container">
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

    <div class="table-container">
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

        <el-table-column align="center" label="Adresa" width="120">
          <template slot-scope="scope">
            <span>{{ scope.row.address }}, {{ scope.row.neighborhood }}, {{ scope.row.city }}, {{ scope.row.county }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Categorie">
          <template slot-scope="scope">
            <span>{{ scope.row.categories | uppercaseFirst }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Status">
          <template slot-scope="scope">
            <el-tag v-if="scope.row.status==='finalizat'" type="success">Finalizat</el-tag>
            <el-tag v-if="scope.row.status==='triaj'">In Triaj</el-tag>
            <el-tag v-if="scope.row.status==='solutionare'" type="info">In proces de solutionare</el-tag>
            <el-tag v-if="scope.row.status==='necesita_voluntar'" type="warning">Necesita voluntar</el-tag>
            <el-tag v-if="scope.row.status==='respins'" type="danger">Respins</el-tag>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Actiuni" width="350">
          <template slot-scope="scope">

            <el-button v-permission="['manage user']" type="primary" size="small" icon="el-icon-edit">
              Edit
            </el-button>

            <el-button v-permission="['manage user']" type="warning" size="small" icon="el-icon-edit" @click="handleEditPermissions(scope.row.id);">
              Raspunsuri formular
            </el-button>
            <el-button v-permission="['manage user']" type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.name);">
              Delete
            </el-button>
          </template>
        </el-table-column>
      </el-table>

      <pagination v-show="total>0" :total="total" :page.sync="query.page" :limit.sync="query.limit" @pagination="getList" />

    </div>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import waves from '@/directive/waves'; // Waves directive
import permission from '@/directive/permission'; // Permission directive
import checkPermission from '@/utils/permission'; // Permission checking
const solicitationsResource = new Resource('solicitations');
export default {
  name: 'SolicitationList',
  components: { Pagination },
  directives: { waves, permission },
  data(){
    return {
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
    };
  },
  mounted(){
    this.getList();
  },
  methods: {
    async getList() {
      const { limit, page } = this.query;
      this.loading = true;
      const { data, meta } = await solicitationsResource.list(this.query);
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

  .filter-container {

    padding: 10px;
  }

  .table-container {

    padding: 10px;

  }

</style>

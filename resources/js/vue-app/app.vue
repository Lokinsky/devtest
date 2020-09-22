<template>
    <div class="cities">
        <div class="list-select">
            <h2 v-text="title" />
            <h3 v-text="'Countries'" />
            <select v-model="currentCountry">
                <option value='-1' disabled selected>-----</option>
                <template  v-for="(item, index) in countries" >
                    <option  :value="item['id']"> {{item['title_'+lang]}}</option>
                </template>
            </select>
            <template v-if="currentCountry>=0&&!regionLoading">
                <div>
                    <h3 v-text="'Regions'" />
                    <select v-model="currentRegion">
                        <option value='0' disabled selected>-----</option>
                        <template  v-for="(item, index) in regions" >
                            <option :value="item['id']"> {{item['title_'+lang]}}</option>
                        </template>
                    </select>
                </div>
            </template>
            <div v-if="regionLoading" class="lds-facebook"><div></div><div></div><div></div></div>
            <template v-if="currentRegion>=0&&!cityLoading">
                <div v-if="cities.length>0">
                    <h3 v-text="'Cities'" />
                    <select v-model="currentCity">
                        <option value='0' disabled selected>-----</option>
                        <template  v-for="(item, index) in cities" >
                            <option :value="item['id']"> {{item['title_'+lang]}}</option>
                        </template>
                    </select>
                </div>
                <span v-else>Empty</span>
            </template>
            <div v-if="cityLoading" class="lds-facebook"><div></div><div></div><div></div></div>
        </div>
        <div class="pagination">
            <div class="card">
                <div class="card-header">
                    <h3>Pagination</h3>
                </div>
                <div v-if="!paginationLoading&&currentRegion>=0" class="pagination-body">
                    <ul>
                        <template v-for="(item, index) in paginationData">
                            <li>{{item['title_'+lang]}}</li>
                        </template>
                    </ul>
                    <footer >
                        <nav aria-label="Page navigation example">
                            <ul class="pagination-controls">
                                <li class="page-item ">
                                    <a class="page-link" tabindex="-1" aria-disabled="true" v-on:click="page-=1">Previous</a>
                                </li>
                                <li class="page-item "><a class="danger">{{page}}</a></li>
                                <li class="page-item"><a class="page-link" v-on:click="page+=1">{{page+1}}</a></li>
                                <li class="page-item"><a class="page-link" v-on:click="page+=2">{{page+2}}</a></li>
                                <li class="page-item">
                                    <a class="page-link" v-on:click="page+=1">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </footer>
                </div>
                <div v-if="paginationLoading" class="lds-facebook"><div></div><div></div><div></div></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => {
        return {
            title: "Map of cities",
            lang:document.documentElement.lang,
            countries:[],
            regions:[],
            cities:[],
            currentCountry:-1,
            currentRegion:-1,
            currentCity:-1,
            cityLoading:false,
            regionLoading:false,
            paginationLoading:false,
            page:0,
            paginationData:[],
        };
    },
    watch:{
        currentCountry(){
            this.refreshApp();
            this.getRegions()
        },
        currentRegion(){
            
            if(this.currentRegion>=0){
                this.getCities();
                this.pagiante();
            }
            
        },
        page(){
            this.pagiante();
        }
    },
    mounted(){
        fetch('http://127.0.0.1:8000/api/country')
            .then(resp => {return resp.json()})
            .then(data => this.countries = data)
            .catch(err=>console.log(err));
    },
    updated(){
    },
    methods:{
        refreshApp(){
            this.regions = [];
            this.cities = [];
            this.currentRegion = -1;
        },
        async getRegions(){
            this.regionLoading = true;
            await fetch('http://127.0.0.1:8000/api/region/'+this.currentCountry)
                .then(resp => {return resp.json();})
                .then(data => this.regions = data)
                .catch(err=>{console.log(err);});
            this.regionLoading = false;
        },
       async getCities(){
            this.cityLoading = true;
            await fetch('http://127.0.0.1:8000/api/city/'+this.currentRegion)
                .then(resp => {return resp.json();})
                .then(data => this.cities = data)
                .then(this.page=1)
                .catch(err=>{console.log(err);});
            this.cityLoading = false;
        },
        async pagiante(){
            this.paginationLoading = true;
            if(this.currentRegion>=0)
                await fetch('http://127.0.0.1:8000/api/city/paginate/'+this.currentRegion+'?page='+this.page)
                    .then(resp => {return resp.json();})
                    .then(data => {
                        this.paginationData = data.data;
                    })
                    .catch(err=>{console.log(err);});
            this.paginationLoading = false;
        }
    }
};
</script>

<style>
*{
    box-sizing:border-box;
    padding:0px;
    margin:0px;
}
li{
    list-style-type: none;
}
a{
    cursor:pointer;
}
.cities {
    display: grid;
    grid-auto-flow: row;
    justify-items:center;
    padding:150px 0px; 
}
select{
    min-width: 20vw;
    max-width: 20vw;
    width:100vw;
    text-align:center;
    font-size: 100%;
    font-weight: bold;
    cursor: pointer;
    border-radius: 0;
    background-color: #c0392b;
    border: none;
    border-bottom: 2px solid #962d22;
    color: white;
    padding: 10px;
     appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    /* Adding transition effect */
    transition: color 0.3s ease, background-color 0.3s ease, border-bottom-color 0.3s ease;
    padding: 10px;
}
select:hover,
select:focus {
  color: #c0392b;
  background-color: white;
  border-bottom-color: #DCDCDC;
}
.list-select{
    display: grid;
    grid-auto-flow: row;
    justify-items:center;
}
.pagination{
    padding:150px 0px 0px 0px ; 
}
.pagination-controls{
    display:grid;
    grid-auto-flow:column;
    grid-column-gap:2em;
}
.pagination-controls>li{
    border: 1px solid black;
}
a:hover{
    box-shadow:1px 1px 1px black;
}
.pagination-body{
    display:grid;
    grid-auto-flow:row;
    grid-row-gap:1em;

}
.pagination-body>ul>{
    border: 1px solid black;
    border-radius:10px;
}
.pagination-body>ul>li:nth-child(odd){
    color:white;
    background-color:black;
}

.danger{
    background-color:red;
    color:white;
}
.lds-facebook {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
  
}
.lds-facebook div {
  display: inline-block;
  position: absolute;
  left: 8px;
  width: 16px;
  background-color:black;
  animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
}
.lds-facebook div:nth-child(1) {
  left: 8px;
  animation-delay: -0.24s;
}
.lds-facebook div:nth-child(2) {
  left: 32px;
  animation-delay: -0.12s;
}
.lds-facebook div:nth-child(3) {
  left: 56px;
  animation-delay: 0;
}
@keyframes lds-facebook {
  0% {
    top: 8px;
    height: 64px;
  }
  50%, 100% {
    top: 24px;
    height: 32px;
  }
}

</style>

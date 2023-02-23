<template>
    <div class="data_grid_container">
        <div class="grid_actions">
            <div v-if="enableSearch" class="search_container">
                <input v-if="enableSearch" class="search" placeholder="Поиск по таблице" type="text" v-model.trim="reqData.search"  v-debounce:400ms="search">
                <a href="#" class="cross" @click="reset('search')"></a>
            </div>
            <div class="tab_filters_container" v-if="columns && tabFilters.length && !selected.length">
                <div class="tab_filter_group" v-for="(tab_group, i) in tabFilters" key="i">
                    <a v-for="tab in tab_group.values" href="#" @click="applyFilter(tab_group, tab)" class="btn" :class="[tab.isActive ? 'btn-primary' : 'btn-secondary']">{{ tab.name }}</a>
                </div>
            </div>
            <div class="mass_actions" v-if="selected.length">
                <div class="count_records">{{ selected.length }} из {{ total_records }} выбрано</div>
                <a class="btn btn-primary" href="#" v-for="(action, i) in mass_actions_data" :key="i" @click="actionRequest(action)">{{ action.label }}</a>
            </div>
        </div>
        <div class="data_grid_table">
            <table>
                <thead>
                <tr>
                    <th v-if="mass_actions" @click="selectAll" class="checkbox fixed">
                        <label class="checkbox__container">
                            <input type="checkbox" :checked="visible.length / 2 <= selectedOnThisPage() && records.length" >
                            <span class="checkmark"></span>
                        </label>
                    </th>
                    <th v-for="(column, i) in columns" :key="column.index" :class="[column.sortable ? 'sortable' : '', i === 0 ? 'fixed' : '']" v-on="column.sortable ? { click: () => sortBy(column) } : {}">
                        <div>{{ column.label }}</div>
                        <div v-if="column.sortable" class="arrow" :class="[{'active' : isColumnActive(column)}, isColumnUp(column) ? 'up' : 'down']"></div>
                    </th>
                </tr>
                </thead>
                <tbody v-if="columns">
                <tr v-if="!records.length">
                    <td class="no_records" :colspan="columns.length + mass_actions">
                        <div class="no_records__title">Записей не найдено</div>
                        <div>
                            <a href="#" class="btn btn-primary" @click="reset('all')">Сбросить фильтры</a>
                        </div>
                    </td>
                </tr>
                <tr v-for="(record, i) in records" :key="record.index" :class="[selected.find(x => x === record[data_index] ) ? 'selected' : '']" @contextmenu.prevent="onContextMenu($event)">
                    <td v-if="mass_actions" @click.self.prevent="selectRow(record)" class="checkbox fixed">
                        <label class="checkbox__container">
                            <input type="checkbox" :checked="selected.find(x => x === record[data_index] )" >
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td v-for="(column, i) in columns" :key="column.index" :class="[ i === 0 ? 'fixed' : '']" @click.prevent="selectRow(record)">
                        <span v-html="record[column.index]"></span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="table_footer">
            <div v-if="columns && paginated && records.length" class="pagination default" >
                <div v-for="link in paginateLinks" class="link" @click="paginateTo(link.url)" :class="[ !link.url ? 'disabled' : '' , link.active ? 'active' : '']">
                    {{ link.label }}
                </div>
            </div>
            <div class="per_page" v-if="paginated && records.length">
                <span>На странице</span><input type="text" v-model="reqData.per_page" v-debounce:400ms="perPage">
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Table",
    data() {
        return {
            reqData: {
                search: "",
                per_page: null,
                filters:[],
                sort:{
                    column:null,
                    value:null,
                }
            },
            index: 'id',
            visible:[],
            selected: [],
        }
    },
    computed:{
        ...mapGetters('grid', ['DATA']),

        data() {
            return this.DATA;
        },
        findModel(index){
            return selected.find(x => x.index === index);
        },
        pages_loaded(){
            return this.pages !== null;
        },
        mass_actions(){
            return this.data.enableMassActions;
        },
        actions(){
            return this.data.enableActions;
        },
        columns(){
            return this.data.columns
        },
        tabFilters(){
            return this.data.tabFilters;
        },
        mass_actions_data(){
            return this.data.massActions;
        },
        actions_data(){
            return this.data.actions;
        },
        total_records(){
            return this.data.records ? this.data.records.total : 0;
        },
        per_page(){
            return this.data.itemsPerPage;
        },
        data_index(){
            this.index = this.data.index;
            return this.data.index;
        },
        records(){
            let ids = [];
            this.data.records.data.forEach(element => {
                ids.push(element[this.data_index])
            });
            this.visible = ids;

            return this.data.records.data;
        },
        paginateLinks(){
            return this.data.records.links ?? [];
        },
        paginated(){
            return this.data.paginated ?? false;
        },
        enableSearch(){
            return this.data.enableSearch ?? false;
        }
    },

    mounted() {
        this.getItemsList();
    },
    methods:{
        ...mapActions('grid', ['LIST']),

        async getItemsList() {
            let resp = await this.LIST({
                params: this.reqData,
                entity: this.$attrs.entity,
            });
            this.reqData.per_page = resp.itemsPerPage;
        },
        isColumnActive(column){
          return column.index === this.reqData.sort.column
        },
        isColumnUp(column){
          return column.index === this.reqData.sort.column && this.reqData.sort.value === 'asc';
        },
        sortBy(column){
            if(!column.sortable){
                console.warn('Неверная операция');
            } else {
                this.reqData.sort = {column: column.index, value: this.reqData.sort.value === 'asc' ? 'desc' : 'asc'}
            }
            this.getItemsList();
        },
        applyFilter(group, tab){
            let index = this.reqData.filters.findIndex((filter) => filter.key === group.key)
            this.reqData.filters.splice(index, 1);
            this.reqData.filters.push({
                key: group.key,
                param: group.key + '[' + group.condition + ']',
                value: tab.key
            })
            this.getItemsList();
        },
        paginateTo(link){
            let url = new URL(link);
            let params = new URLSearchParams(url.search);
            for (let pair of params.entries()){
                this.reqData[pair[0]] = pair[1];
            }
            this.getItemsList();
        },
        search(){
            this.reset('page');
            // this.getItemsList();
        },
        perPage(){
            this.reset('page');
            // this.getItemsList();
        },
        reset(tag){
            switch (tag) {
                case "all":
                    this.reqData.search = "";
                    this.selected = [];
                    this.reqData.sort = {
                        column:null,
                        value:null,
                    }
                    break;
                case 'search':
                    this.reqData.search = null;
                    break;

                case 'page':
                    this.reqData.page = null;
                    break;
            }
            this.getItemsList();
        },

        // MASS ACTIONS

        selectRow(row){

            let record = this.visible.find(record => record === row[[this.data_index]]);
            let index = this.selected.findIndex(x => x === record );
            let target = event.target.closest('tr').querySelector('.checkbox input');
            target.checked = !target.checked;
            if(target.checked){
                // this.selected.concat(row[this.data_index]).unique();

                index === -1 ? this.selected.push(record) : null;
            } else {
                let indexToDelete = this.selected.findIndex(x => x === record );
                this.selected.splice(indexToDelete, 1);
            }


            this.selected.push();
        },
        selectAll(){
            // console.log(event.target.querySelector('input').checked)
            let target = event.target.querySelector('input');
            target.checked = !target.checked;
            if(event.target.querySelector('input').checked){
                this.selected = this.selected.concat(this.visible).unique();
            } else {
                // let exclude = this.visible;

                this.selected = this.selected.filter( ( el ) =>  {
                    return this.visible.indexOf( el ) < 0;
                } );
            }
        },
        actionRequest(action){

            let data = {};
            for (const [key, value] of Object.entries(JSON.parse(action.expect))) {
                data[key] = this[key];
            }
            axios({
                method: action.method,
                url: action.action,
                data: data
            }).then(() => {
                this.reset('all');
            });
        },
        selectedOnThisPage(){
            return this.selected.filter(value => this.visible.includes(value)).length
        },
        onContextMenu(e) {

            let items = [];
            if(this.actions){
                for (let action of this.actions_data){
                    let item = {
                        label: action.title,
                        onClick: () => {
                            this.actionRequest(action);
                        }
                    }
                    items.push(item);
                }
            }
            if(this.mass_actions && this.selected.length){
                let mass_actions = [];
                for (let action of this.mass_actions_data){
                    let item = {
                        label: action.label,
                        onClick: () => {
                            this.actionRequest(action);
                        }
                    }
                    mass_actions.push(item);
                }
                items.push({
                    label: "С выделеными (" + this.selected.length + ")",
                    children: mass_actions
                });
            }

            let options = {
                x: e.x,
                y: e.y,
                items
            }
            this.$contextmenu(options);
        }
    }
}
</script>

<style scoped>

</style>
<template>
    <div class="add-activite modal-btn list-notes-match">
        <button class="btn btn-soccer-coach-action-list"  data-toggle="modal" :data-target="'#modalListNote' + activite.id" @click="getListNotesByActivite()"><i class="fa fa-comment"></i></button>
        <div :id="'modalListNote' + activite.id" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{activite.nom}} {{activite.date_debut}}</h4>
                        <button type="button" class= "close btn-close" :id="'closemodalListNote' + activite.id" @click="closeModal()">&times;</button>              
                    </div>
                    <div class="modal-body"> 
                        <div class="btn-action-notes">
                            <div class="btns">
                                <a class="show-form-add-note" @click="showFormToAdd()" v-if="!showForm">Ajouter note +</a>
                                <a class="show-form-add-note" @click="showFormToAdd()" v-else>Ajouter note -</a>
                            </div>
                        </div>
                        <div class="form-add-note" v-if="showForm"> 
                            <div class="form-group">
                                <label :for="'noteNom'+indexAct"> Note:</label>
                                <text-area  placeholder="Ex: Notes du match ..." v-model="noteDTO.note.value" :name="'noteNom'+indexAct"
                                        :model="noteDTO.note" @validation="noteDTO.note.validate = $event"/>
                            </div>
                            <div class="btn-action-notes">
                                <div class="btns">
                                    <a class="btn btn-soccer-coach-action" @click="saveNote()"><i class="fa fa-plus"></i> Ajouter note</a>
                                </div>
                            </div>
                        </div>
                        <bounce  color="17b87d" v-show="isLoading"></bounce>
                        <div class="notes" v-if="!isLoading && !showForm">                   
                            <div class="aucune-note" v-if="lstNotes.length === 0">Aucune note</div>
                            <div class="note-item" v-for="(note, indexN) in displayListNotes" :key="indexN">
                                <div class="note"> 
                                    <div class="note-header">
                                        <span class="date-creation-note">{{note.date_creation}}</span> 
                                        <span class="user-creation" v-if="note.nameUser"> - {{note.nameUser}}</span>
                                    </div>
                                    <div class="note-body">                                  
                                        {{note.note}} 
                                    </div>        
                                </div>
                                <div class="actions">
                                    <button class="btn delete-note" @click="deleteNote(note.id, indexN)"><i class="ti-trash"></i></button>
                                </div> 
                            </div> 
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item">
                                        <button type="button" class="page-link" v-if="page != 1" @click="page--"><i class="ti-angle-double-left"></i></button>
                                    </li>
                                    <li class="page-item">
                                        <button type="button" class="page-link" v-for="pageNumber in pages.slice(page-1, page+5)" :key="pageNumber" @click="page = pageNumber"> {{pageNumber}} </button>
                                    </li>
                                    <li class="page-item">
                                        <button type="button" @click="page++" v-if="page < pages.length" class="page-link"><i class="ti-angle-double-right"></i></button>
                                    </li>
                                </ul>
                            </nav>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState, mapMutations, mapGetters } from 'vuex' 
export default {
    props:['activite', 'indexAct'],
    data(){
        return {
            lstNotes:[],
            isLoading : true,
            noteDTO:{
                note:{
                    value:undefined,
                    validations:{
                        require:true,
                        max:400
                    },
                    validate:false
                }
            },
            showForm:false,
            page: 1,
            perPage: 9,
            pages: [],
        }
    },
    computed:{
        displayListNotes(){     
            return this.paginate(this.lstNotes.sort((a,b) =>(a.date_creation > b.date_creation ? 1 : -1)));
        },
        ...mapState(['mapNotesMatch']),
        ...mapGetters(['getNotesByActivite'])
    },
    watch: {
        lstNotes () {
            this.setPages();
        }
    },
    filters: {
        trimWords(value){
            return value.split(" ").splice(0,20).join(" ") + '...';
        }
    },
    methods:{
        setPages () {
            let numberOfPages = Math.ceil(this.lstNotes.length / this.perPage);
            if(numberOfPages > 1){
                for (let index = 1; index <= numberOfPages; index++) {
                    this.pages.push(index);
                }
            }
        },
        paginate (note) {
            let page = this.page;
            let perPage = this.perPage;
            let from = (page * perPage) - perPage;
            let to = (page * perPage);
            return  note.slice(from, to);
        },
        closeModal(){
            this.lstNotes = []; //init la liste de notes    
            $("#modalListNote" + this.activite.id).modal("hide");
        },
        getListNotesByActivite(){

            //vérifier s'il y a déjà des présences dans la liste de présences du store pour l'activité
            let notesByActivite = this.getNotesByActivite(this.activite.id); 
            if(notesByActivite){   
                this.lstNotes = notesByActivite;
                this.isLoading = false;
            }else{			
                axios.get('/equipes/get-notes-by-activite/'+this.activite.id).then(response =>{
                    this.lstNotes = response.data.notes;
                    if(this.lstNotes.length > 0){
                        //ajouter les notes de l'activité dans la liste du store
                        let param = {
                            idActivite: this.activite.id,
                            notes:this.lstNotes
                        };
                        this.addNoteToMatch(param);
                    }
                    this.isLoading = false;
                });
            }
        },
        deleteNote(idNote, index){
            axios.delete('/equipes/delete-note/'+idNote).then(response =>{
                this.lstNotes.splice(index, 1);
            });
        },
        saveNote(){
            if(this.noteDTO.note.validate){
                let param = {
                    note:this.noteDTO.note.value,
                    date:new Date(),
                    idActivite:this.activite.id
                };
                axios.post('/equipes/create-note', param).then(response =>{
                    this.showForm = false;
                    this.lstNotes.push(response.data.note);
                    //init DTO
                    this.noteDTO ={
                        note:{
                            value:undefined,
                            validations:{
                                require:true,
                                max:400,
                            },
                            validate:false
                        }
                    };
                });
            }
        },
        showFormToAdd(){
            this.showForm = !this.showForm ? true : false;
        },
        ...mapMutations(['clearMapNotesMatch', 'addNoteToMatch', 'deleteNotesByActivite', 'setMapNotesMatch'])
    },
    mounted() {}
}
</script>
<style lang="scss" scoped>
    @import '../../../../../public/css/forms';
    @import '../../../../../public/css/modals/addActivite';
    @import '../../../../../public/css/modals/notesMatch';
</style>

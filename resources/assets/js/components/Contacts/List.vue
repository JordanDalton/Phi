<template>
    <div>

        <div class="p-4">
            <h1 class="mb-6" v-show="showTitle">Contacts ({{ total }})</h1>
            <h1 class="mb-6" v-show="show.form">{{ this.form.type == 'create' ? 'Add Contact' : 'Update Contact' }}</h1>
            <a class="bg-green text-white mt-8 p-3 rounded no-underline" href="#" v-show="showButton" @click="show.form = true; show.table=false">Add Contact</a>
        </div>

        <div class="bg-green text-white font-bold p-4" v-show="success">{{ success }}</div>

        <div class="" v-if="show.form">

          <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4" v-if="errors">
                <ul>
                    <li v-for="(error, field) in errors" class="text-red">
                        {{ error[0] }}
                    </li>
                </ul>
            </div>

            <div class="mb-4">
              <label class="block text-grey-darker text-sm font-bold mb-2" for="name">
                Name
              </label>
              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight" id="name" type="text" placeholder="John Doe" v-model="form.name">
            </div>
            <div class="mb-4">
              <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                Email
              </label>
              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight" id="email" type="text" placeholder="john@johndoe.com" v-model="form.email">
            </div>
            <div class="mb-4">
              <label class="block text-grey-darker text-sm font-bold mb-2" for="phone">
                Phone
              </label>
              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight" id="phone" type="text" placeholder="8889991234" v-model="form.phone">
            </div>
            <div class="mb-4">
              <label class="block text-grey-darker text-sm font-bold mb-2" for="city">
                City
              </label>
              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight" id="city" type="text" placeholder="Austin" v-model="form.city">
            </div>
            <div class="mb-4">
              <label class="block text-grey-darker text-sm font-bold mb-2" for="state">
                State
              </label>
              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight" id="state" type="text" placeholder="TX" v-model="form.state">
            </div>
            <div class="mb-4">
              <label class="block text-grey-darker text-sm font-bold mb-2" for="zip">
                Zip
              </label>
              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight" id="zip" type="text" placeholder="76504" v-model="form.zip">
            </div>
            <div class="flex items-center justify-between">
              <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" type="button" @click="submitForm">
                Submit
              </button>
            </div>
          </form>
        </div>
        <table class="text-left m-4" style="border-collapse" v-show="show.table">
        <thead>
            <tr>
                <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Edit</th>
                <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Name</th>
                <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Email</th>
                <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Phone</th>
                <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">City</th>
                <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">State</th>
                <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Zips</th>
                <th class="py-4 px-6 bg-grey-lighter font-sans font-medium uppercase text-sm text-grey border-b border-grey-light">Delete</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover:bg-blue-lightest" v-for="(contact, key) in contacts">
                <td class="py-4 px-6 border-b border-grey-light">
                    <a href="#" @click="showEditForm(key)">Edit</a>
                </td>
                <td class="py-4 px-6 border-b border-grey-light">
                    {{ contact.name }}
                </td>
                <td class="py-4 px-6 border-b border-grey-light text-center">
                    {{ contact.email }}
                </td>
                <td class="py-4 px-6 border-b border-grey-light text-center">
                    {{ contact.phone }}
                </td>
                <td class="py-4 px-6 border-b border-grey-light text-center">
                    {{ contact.city }}
                </td>
                <td class="py-4 px-6 border-b border-grey-light text-center">
                    {{ contact.state }}
                </td>
                <td class="py-4 px-6 border-b border-grey-light text-center">
                    {{ contact.zip }}
                </td>
                <td class="py-4 px-6 border-b border-grey-light">
                    <a class="bg-red text-white p-2 rounded no-underline" href="#" @click="destroy(contact)">Delete</a>
                </td>
            </tr>
        </tbody>
        </table>
    </div>
</template>

<script>
    export default {

        data(){

            return {

                errors : [],

                form : {
                    type : 'create',
                    name : null,
                    email : null,
                    phone: null,
                    city: null,
                    state: null,
                    zip : null
                },

                contacts : [],

                success : null,

                show : {
                    form : false,
                    table : true
                }
            }
        },

        methods : {

            fetch(){
                axios.get('/api/contacts').then((response) => {
                    this.contacts = response.data.data;
                })
            },

            store(){
                axios.post('/api/contacts', this.form).then(response => {

                    Object.assign(this.$data, this.$options.data())

                    this.fetch();

                }, error => {

                    this.errors = error.response.data.errors;
                })
            },

            update(){
                axios.put(this.form.urls.update, this.form).then(response => {

                    Object.assign(this.$data, this.$options.data())

                    this.fetch();

                }, error => {

                    this.errors = error.response.data.errors;
                })
            },

            destroy(contact){

                axios.delete('/api/contacts/' + contact.id).then(response => {

                    Object.assign(this.$data, this.$options.data())

                    this.fetch();

                }, error => {

                    this.errors = error.response.data.errors;
                })
            },

            showCreateForm()
            {
                this.show.form = true;
                this.show.table = false;

                this.form.type = 'create';
                this.custom_title = true;
            },

            showEditForm(key){

                this.show.form = true;
                this.show.table = false;

                this.form      = this.contacts[key];
                this.form.type = 'update';
                this.custom_title = true;
            },

            submitForm(){

                if(this.type == 'create'){
                    this.store();
                } else {
                    this.update();
                }

            }
        },

        computed : {

            showButton(){
                return ! this.show.form;
            },

            showTitle(){
                return this.showButton;
            },

            total(){
                return this.contacts.length;
            },

            type(){
                return this.form.type;
            }
        },

        mounted() {
            this.fetch()
        }
    }
</script>
export default {
    data() {
        return {
            fields: {},
            errors: {},
            success: false,
            loaded: true,
            action: '',
            update: false,
            response: '',
        }
    },
    methods: {
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = '';
                this.errors = {};
                axios.post(this.action, this.fields).then(response => {
                    this.loaded = true;
                    this.success = response.data.status;
                    this.response = response.data.data;
                    // if (response.data.customRes != undefined) {
                    //     this.customResponse = response.data.customRes;
                    // }
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422 || error.response.status === 429) {
                        this.errors = error.response.data.errors || {};
                    }
                })
            }
        },
        delete(url) {
            this.success = '';
            axios.delete(url).then(response =>{
                this.success = response.data.status;
                this.response = response.data.data;
            });
        },
        edit(url) {
            this.update = '';
            axios.get(url).then(response =>{
                this.update = response.data.status;
                this.fields = response.data.data;
            });
        }
    }
}
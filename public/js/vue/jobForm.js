

new Vue({
    el:'#app',
    components: {
        Multiselect: window.VueMultiselect.default
    },
    cache: false,
    data : {
            selected:null,
            categories:[],
            step: 1,
            file :'',
            registration : {
                name:null,
                email:null,
                location:null,
                // industry:{ language: 'JavaScript', library: 'Vue-Multiselect' },
                industry:null,
                position:null,
                key_skills:null,
                environment:null,
                fileName :'',
                salary_expectation:null
            },
        industryOptions: [],
        positionOptions: [],
        keySkillsOptions: [],
        environmentOptions: [],
        salaryOptions: [],
        success:[],
        errors:[]

    },
    created: function () {
        this.dropDownOptions();
    },
    methods:{

        dropDownOptions : function(){

            this.$http.get('/dev/drop-down-options').then(response => {

                var dropDownOptions = response.body.data;
                for(var i=0; i < dropDownOptions.length; i++){
                    console.log('dropdown', dropDownOptions[i].data.drop_down_name);
                    if((dropDownOptions[i].data.drop_down_name).trim() == 'industries'){
                        this.industryOptions.push(dropDownOptions[i].data.drop_down_value);
                    }

                    if((dropDownOptions[i].data.drop_down_name).trim() == 'positions'){
                        this.positionOptions.push(dropDownOptions[i].data.drop_down_value);
                    }

                    if((dropDownOptions[i].data.drop_down_name).trim() == 'skills'){
                        this.keySkillsOptions.push(dropDownOptions[i].data.drop_down_value);
                    }

                    if((dropDownOptions[i].data.drop_down_name).trim() == 'environment'){
                        this.environmentOptions.push(dropDownOptions[i].data.drop_down_value);
                    }

                    if((dropDownOptions[i].data.drop_down_name).trim() == 'salary'){
                        this.salaryOptions.push(dropDownOptions[i].data.drop_down_value);
                    }
                }


            }, response => {
                    // error callback
                });

        },
        onFileChange : function(e){

            var files = e.target.files || e.dataTransfer.files;
            console.log(files[0].name.split('.')[1]);
            // console.log(files);
            if (!files.length)
            {
                this.file = 0;
                return;
            }

            this.file = (files[0].name.split('.')[1]).trim();
            this.registration.fileName = files[0];
            console.log('files', this.registration.fileName);
        },
        prev : function() {
            this.step--;
        },
        next : function() {

            this.errors = [];

            if(this.step == 1){

                if(!this.registration.name){
                    this.errors.push("Name required.");
                }

                if(!this.registration.email){
                    this.errors.push("Email required.");
                }

                if(!this.validateEmail(this.registration.email)){
                    this.errors.push("Email invalid.");
                }

                if(this.registration.location == null){
                    this.errors.push("Location required.");
                }


                if (!this.errors.length){
                    this.step++;
                    console.log('step number', this.step);
                }


            }
            else if(this.step == 2){

                if(!this.registration.industry){
                    this.errors.push("Industry required.");
                }

                if(!this.registration.position){
                    this.errors.push("Position required.");
                }

                if(!this.registration.key_skills){
                    this.errors.push("Key Skills required.");
                }

                if(!this.registration.environment){
                    this.errors.push("Environment required.");
                }

                if(!this.registration.salary_expectation){
                    this.errors.push("Salary required.");
                }

                if(this.file == 0){
                    this.errors.push("Resume required.");
                }

                if(this.file != 'pdf' && this.file != 'docx' && this.file != 'docs' && this.file != 'doc'){
                    this.errors.push("Valid format of resume required.");
                }

                if (!this.errors.length){
                    this.step++;
                    //console.log('indus', this.registration);
                }
            }
        },
        validateEmail : function (email) {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        },
        stepOne : function() {
            this.step = 1;
        },
        stepTwo : function() {
            this.step = 2;
        },
        stepThree : function() {

            this.step = 3;
        },
        submit : function() {

            var formData = new FormData();
            // append string
            formData.append('name', this.registration.name);
            formData.append('email', this.registration.email);
            formData.append('location', this.registration.location);
            formData.append('industry', this.registration.industry);
            formData.append('position', this.registration.position);
            formData.append('key_skills', this.registration.key_skills);
            formData.append('environment', this.registration.environment);
            formData.append('salary_expectation', this.registration.salary_expectation);

            // append Blob/File object
            formData.append('resume', this.registration.fileName, this.registration.fileName.name);


            this.$http.post('/dev/build-job', formData).then(response => {

                this.success.push('Application sent successfully.');
                // console.log("response", response);
                setTimeout(
                    window.location.href = '/dev'
                    , 10000);

        }, response => {
                // error callback
            });
        }
    }
});


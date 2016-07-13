angular.module('magazijn').controller('createEmailhandtekeningCtrl',['$scope','$http','$location','ngToast', function($scope,$http,$location,ngToast){

    var getUserInfo = function(){
        $http.get('/user').success(function(data){$scope.userdata = data;});
    }

    var getSignatures = function(){
        $http.get('/emailhandtekeningen/get').success(function(data){
            $scope.signatures = data;

        });

    }
    
    $scope.functie = 1;
    $scope.gsmnummer = "+32 (0)4";
    
    $('.functiedropdown')
        .dropdown({
            onChange: function(value, text, $selectedItem) {

                $('.confirmbtn').hide();
                $('.previewbtn').show();

                $scope.functie = value;
                $scope.functienaam = text;

                if(value == 2){
                    $scope.officemanager = 1
                    $('.officemanagergsm').show();
                }else{
                    $scope.officemanager = 0;
                    $('.officemanagergsm').hide();
                }

            }
        })
    ;
    
    
    
    var canvas = document.getElementById('canvas');
    var drawSignature = function(){
        

        canvas.style.width=500;//actual width of canvas
        canvas.style.height=147;//actual height of canvas
        var ctx = canvas.getContext('2d');

        var imageObj = new Image();
        imageObj.src = 'images/email_signature_templates/'+$scope.userdata.section+'.png';
        imageObj.onload = function() {
            ctx.drawImage(imageObj, 0, 0);
        };

        ctx.fillStyle = '#fff';
        ctx.fillRect(0,0,500,147);

        ctx.fillStyle = '#009fe3';
        ctx.font = ' 600 14pt eurostilebold';
        ctx.fillText($scope.voornaam + " " + $scope.naam, 20, 20 );
        ctx.fillStyle = '#ea5b0c';
        ctx.font = 'italic 11pt eurostilebold';
        ctx.fillText($scope.functienaam, 20, 35 );

        ctx.fillStyle = '#000';
        ctx.font = '8pt eurostilebold';
        ctx.fillText($scope.userdata.address + " - " +$scope.userdata.postalcode + " " +$scope.userdata.city, 20, 60 );

        ctx.fillStyle = '#009fe3';
        ctx.font = '8pt eurostilebold';
        ctx.fillText("T", 20, 75 );

        ctx.fillStyle = '#009fe3';
        ctx.font = '8pt eurostilebold';
        ctx.fillText("F", 150, 75 );

        ctx.fillStyle = '#000';
        ctx.font = '8pt eurostilebold';
        ctx.fillText($scope.userdata.phone, 30, 75 );

        ctx.fillStyle = '#000';
        ctx.font = '8pt eurostilebold';
        ctx.fillText($scope.userdata.fax, 160, 75 );


        var naam = $scope.naam;
        naam = naam.replace(/\s+/g, '');
        $scope.nameemail = $scope.voornaam + "." + naam;

        if($scope.officemanager){
            ctx.fillStyle = '#009fe3';
            ctx.font = '8pt eurostilebold';
            ctx.fillText("GSM", 20, 90 );

            ctx.fillStyle = '#000';
            ctx.font = '8pt eurostilebold';
            ctx.fillText($scope.gsmnummer, 45, 90 );

            ctx.fillStyle = '#009fe3';
            ctx.font = '8pt eurostilebold';
            ctx.fillText("E", 160, 90 );

            ctx.fillStyle = '#000';
            ctx.font = '8pt eurostilebold';
            switch($scope.userdata.section)
            {
                case "KIV":
                    ctx.fillText($scope.nameemail.toLowerCase() + "@konvert.be", 170, 90 );
                    break;
                case "KO":
                    ctx.fillText($scope.nameemail.toLowerCase() + "@konvertoffice.be", 170, 90 );
                    break;
                case "KK":
                    ctx.fillText($scope.nameemail.toLowerCase() + "@konstrukt.be", 170, 90 );
                    break;
                default:
                    ctx.fillText($scope.nameemail.toLowerCase() + "@konvert.be", 170, 90 );
            }

        }else{
            ctx.fillStyle = '#009fe3';
            ctx.font = '8pt eurostilebold';
            ctx.fillText("E", 20, 90 );

            ctx.fillStyle = '#000';
            ctx.font = '8pt eurostilebold';
            switch($scope.userdata.section)
            {
                case "KIV":
                    ctx.fillText($scope.nameemail.toLowerCase() + "@konvert.be", 30, 90 );
                    break;
                case "KO":
                    ctx.fillText($scope.nameemail.toLowerCase() + "@konvertoffice.be", 30, 90 );
                    break;
                case "KK":
                    ctx.fillText($scope.nameemail.toLowerCase() + "@konstrukt.be", 30, 90 );
                    break;
                default:
                    ctx.fillText($scope.nameemail.toLowerCase() + "@konvert.be", 30, 90 );
            }

        }

        
    }
    
    $scope.confirmSignature = function(){
        $scope.imagedir = $scope.nameemail;

        $signaturedata = {
            'user_id' : $scope.userdata.id,
            'name' : ""+$scope.voornaam+" "+$scope.naam,
            'function': $scope.functie,
            'image': ""+$scope.voornaam+""+$scope.naam,
            'gsm': $scope.gsmnummer,
            'approved': 0
        }
        
        var dataURL = canvas.toDataURL('image/jpg');
        $http.post('/emailhandtekeningen/image',{'filename':$scope.voornaam+""+$scope.naam, 'image':dataURL}).success(function(data){console.log(data)});

        $http.post('/emailhandtekeningen/save', $signaturedata).success(function(data){
            ngToast.create({
                className: 'success',
                content: 'De email handtekening werd succesvol geregistreerd voor goedkeuring!'
            });
            resetForm();
            getSignatures();
            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);

        });
    }

    $scope.addSignature = function(){

        getUserInfo();
        
        console.log($scope.functie);

        if(!$scope.functie == 2 && $scope.voornaam.length != 0 && $scope.naam.length != 0)
        {
            drawSignature();
            
            $('.confirmbtn').show();
            
        }else if($scope.functie == 2 && $scope.gsmnummer.length < 5 && $scope.voornaam.length != 0 && $scope.naam.length != 0){
            $('.officemanagergsm').css('border-color','#FF8888');
        }else{
            drawSignature();
            
            $('.confirmbtn').show();
        }

        if($scope.functie == 1 && $scope.voornaam.length > 0 && $scope.naam.length > 0){
            drawSignature();
            
            $('.confirmbtn').show();
        }

    }

    var resetForm = function(){
        $('#handtekeningform input').val("");
        $('.functiedropdown').dropdown('clear');
    }

    $scope.removeSignature = function(id){
        $http.get('/emailhandtekeningen/remove/'+id).success(function(data){console.log(data);getSignatures()});
    }

    

    // DOWNLOAD SIGNATURE

    $scope.download = function(image)
    {
        window.location = "/emailhandtekeningen/download/"+image;
    }

    // INIT

    $scope.init = function(){
        $('.officemanagergsm').hide();
        $('.previewbtn').hide();
        $('.confirmbtn').hide();
        getUserInfo();
        getSignatures();
        $('input').on('focus',function(e){$(e.currentTarget).value = "";});
    };

    $scope.init();

    //CANVAS



}]).config(['ngToastProvider', function(ngToast) {
    ngToast.configure({
        verticalPosition: 'top',
        horizontalPosition: 'center',
        maxNumber: 3,
        animation: 'fade'
    })}]);



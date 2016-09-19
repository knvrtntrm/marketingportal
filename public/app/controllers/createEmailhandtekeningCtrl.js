angular.module('magazijn').controller('createEmailhandtekeningCtrl',['$scope','$http','$location','ngToast','$filter', function($scope,$http,$location,ngToast,$filter){

    var getUserInfo = function(){
        $http.get('/user').success(function(data){$scope.userdata = data;});

    }

    var getSignatures = function(){
        $http.get('/emailhandtekeningen/get').success(function(data){
            $scope.signatures = data;

        });

    }
    
    $scope.functie = 1;
    $scope.gsmnummer = "+32 4";
    
    $('.functiedropdown').on('change', function(e){
            $('.confirmbtn').hide();

            if(this.value != 0){
                $('.previewbtn').show();
            }else{
                $('.previewbtn').hide();
            }
            

            $scope.functie = this.value;
            $scope.functienaam = $('option:selected').text();

            if(this.value == 2){
                $scope.officemanager = 1
                $('.officemanagergsm').show();
            }else{
                $scope.officemanager = 0;
                $('.officemanagergsm').hide();
            }
        });
    
    
    var canvas = document.getElementById('canvas');
    var drawSignature = function(){
        

        canvas.style.width=850;//actual width of canvas
        canvas.style.height=300;//actual height of canvas
        var ctx = canvas.getContext('2d');

        var imageObj = new Image();
        imageObj.src = 'images/email_signature_templates/'+$scope.userdata.section+'.png';
        imageObj.onload = function() {
            ctx.drawImage(imageObj, 0, 70, 600, 230);
        };

        ctx.fillStyle = '#fff';
        ctx.fillRect(0,0,700,300);

        ctx.fillStyle = '#1f1e1d';
        ctx.font = ' 600 18pt Open Sans';
        ctx.fillText($scope.voornaam + " " + $scope.naam, 20, 20 );
        ctx.fillStyle = '#1f1e1d';
        ctx.font = '400 italic 18pt Open Sans';
        ctx.fillText($scope.functienaam + " " + $scope.userdata.city, 20, 45 );

        ctx.fillStyle = '#1f1e1d';
        ctx.font = ' 12pt Open Sans';
        ctx.fillText($scope.userdata.address + ", " +$scope.userdata.postalcode + " " +$scope.userdata.city, 262, 138 );

        ctx.fillStyle = '#1f1e1d';
        ctx.font = ' 12pt Open Sans';
        ctx.fillText("T", 262, 160 );

        ctx.fillStyle = '#1f1e1d';
        ctx.font = ' 12pt Open Sans';
        ctx.fillText($scope.userdata.phone, 274, 160 );


        var naam = $scope.naam;
        naam = naam.replace(/\s+/g, '');
        $scope.fullname = $scope.voornaam + "." + naam;

        if($scope.officemanager){
            ctx.fillStyle = '#1f1e1d';
            ctx.font = ' 12pt Open Sans';
            ctx.fillText(String.fromCharCode("8226") + " GSM", 417, 160 );

            ctx.fillStyle = '#1f1e1d';
            ctx.font = ' 12pt Open Sans';
            ctx.fillText($scope.gsmnummer, 467, 160 );
        }

        ctx.fillStyle = '#1f1e1d';
        ctx.font = ' 12pt Open Sans';

        if(!$scope.officemanager)
        {
            switch($scope.userdata.section)
            {
                case "KIV":
                    ctx.fillText($scope.userdata.email.toLowerCase() +String.fromCharCode("8226")+" www.konvert.be", 262, 180 );
                    break;
                case "KO":
                    ctx.fillText($scope.userdata.email.toLowerCase() +String.fromCharCode("8226")+ " www.konvert.be", 262, 180 );
                    break;
                case "KK":
                    ctx.fillText($scope.userdata.email.toLowerCase() +String.fromCharCode("8226")+" www.konvert.be", 262, 180 );
                    break;
                default:
                    ctx.fillText($scope.userdata.email.toLowerCase() +String.fromCharCode("8226")+" www.konvert.be", 262, 180 );
            }
        }
        else{
            switch($scope.userdata.section)
            {
                case "KIV":
                    ctx.fillText("officemanager."+$scope.userdata.city.toLowerCase()+"@konvert.be "+String.fromCharCode("8226")+" www.konvert.be", 262, 180 );
                    break;
                case "KO":
                    ctx.fillText("officemanager."+$scope.userdata.city.toLowerCase() + "@konvertoffice.be "+String.fromCharCode("8226")+ " www.konvert.be", 262, 180 );
                    break;
                case "KK":
                    ctx.fillText("officemanager."+$scope.userdata.city.toLowerCase() + "@konstrukt.be "+String.fromCharCode("8226")+" www.konvert.be", 262, 180 );
                    break;
                default:
                    ctx.fillText("officemanager."+$scope.userdata.city.toLowerCase() + "@konvert.be "+String.fromCharCode("8226")+" www.konvert.be", 262, 180 );
            }
        }

        
    }
    
    $scope.confirmSignature = function(){
        $scope.imagedir = $scope.nameemail;

        if($scope.functie == "Office manager"){
            $signaturedata = {
            'user_id' : $scope.userdata.id,
            'name' : ""+$scope.voornaam+" "+$scope.naam,
            'function': $scope.functie,
            'image': ""+$scope.voornaam+""+$scope.naam,
            'gsm': $scope.gsmnummer,
            'approved': 0
            }
        }else{
            $signaturedata = {
            'user_id' : $scope.userdata.id,
            'name' : ""+$scope.voornaam+" "+$scope.naam,
            'function': $scope.functie,
            'image': ""+$scope.voornaam+""+$scope.naam,
            'approved': 0
            }
        }

        
        
        var dataURL = canvas.toDataURL('image/jpg');
        $http.post('/emailhandtekeningen/image',{'filename':$scope.voornaam+""+$scope.naam, 'image':dataURL}).success(function(data){console.log(data)});

        $http.post('/emailhandtekeningen/save', $signaturedata).success(function(data){
            ngToast.create({
                className: 'success',
                content: $filter('translate')('EMAIL_REGISTER_SUCCESS')
            });
            //resetForm();
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



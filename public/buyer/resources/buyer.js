(function($) {
	"use strict";
	var HT = {}; // Khai báo là 1 đối tượng
	
    HT.loadDistrict = () => {
        $(document).on('change', '.city', function(){
            let _this = $(this)
            let data = {
                city_id: _this.val()
            }
            $.ajax({
                url: 'ajax/buyer/getDistrict', 
                type: 'GET', 
                data: data,
                dataType: 'json', 
                success: function(res) {
                    $('.district').html(res.html).val(district_id).trigger('change')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  
                  console.log('Lỗi: ' + textStatus + ' ' + errorThrown);
                }
            });
        })
    }


    HT.loadWard = () => {
        $(document).on('change', '.district', function(){
            let _this = $(this)
            let data = {
                district_id: _this.val()
            }
            $.ajax({
                url: 'ajax/buyer/getWard', 
                type: 'GET', 
                data: data,
                dataType: 'json', 
                success: function(res) {
                    $('.ward').html(res.html).val(ward_id)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  
                  console.log('Lỗi: ' + textStatus + ' ' + errorThrown);
                }
            });
        })
    }

    HT.preLoadCity = () => {
        if(province_id != ''){
            $(".city").val(province_id).trigger('change');
        }
    }


    $(document).ready(function(){
        HT.loadDistrict()
        HT.loadWard()
        HT.preLoadCity()
    })

})(jQuery);



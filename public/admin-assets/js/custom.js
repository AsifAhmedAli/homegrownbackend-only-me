/**
 * Created by   :  Muhammad Yasir
 * Project Name : yra
 * Product Name : PhpStorm
 * Date         : 29-Aug-19 2:43 PM
 * File Name    : custom.js
 */

$(document).ready(function () {
  $('.date_calender').datetimepicker({
                                       viewMode: 'days',
                                       format: 'DD/MM/YYYY' /*Add this line to remove time format*/
                                     });

  $('.form-edit-add').validate({errorClass: 'text-danger'});

  // add remove custom input fields while add new attribute and value
  var wrapper = $(".input_wrap");
  var add_button = $(".add_field_button");
  var add_on_edit_btn = $(".add_edit_field_button");

  // for add attribute page
  $(add_button).click(function (e) {
    e.preventDefault();
    $(wrapper).append('<div class="form-group col-md-12"><div><input type="text" name="value[]" required class="form-control col-md-12"><a href="#" class="remove_field">Remove</a></div></div>'); //add input box
  });

  //for edit attribute page
  $(add_on_edit_btn).click(function (e) {
    e.preventDefault();
    $(wrapper).append('<div class="form-group col-md-12"><div><input type="text" name="value[]" required class="form-control col-md-12"><a href="#" class="remove_field_edit">Remove</a></div></div>'); //add input box
  });


  // for add attribute page
  $(document).on("click", ".remove_field", function () {
    $(this).parent().remove();
  });


  // for edit attribute page
  $(document).on("click", ".remove_field_edit", function () {
    $(this).parent().remove();
  });

});


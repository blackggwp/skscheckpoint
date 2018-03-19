// Wait for the DOM to be ready
$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
  
    $("form[name='checkPoint_form']").validate({
      // It will enable hidden field validation.
      // So You will get validation for Select 2
      ignore: [],
      // ignore: 'input[type=hidden]',
      // Specify validation rules
      rules: {
        // The key name on the left side is the name attribute
        // of an input field. Validation rules are defined
        // on the right side
        customerid: "required",
        customerid: {
          required: true,
          number: true,
          minlength: 8,
          maxlength: 8
        }
      },
      // Specify validation error messages
      messages: {
        customerid: {
          required: "กรุณาระบุรหัสบัตรสมาชิก",
          number: "กรุณาระบุเป็นตัวเลข",
          minlength: "กรุณากรอกรหัสอย่างน้อย 8 ตัวอักษร",
          maxlength: "กรุณากรอกรหัสไม่เกิน 8 ตัวอักษร"
        }
      },
      // Make sure the form is submitted to the destination defined
      // in the "action" attribute of the form when valid
      submitHandler: function(form) {
        form.submit();
      }
    });
  });
  
jQuery(function() {
  // const userBlockDeleteModal = new bootstrap.Modal('#userBlockDeleteModal', {
  //   keyboard: false
  // });
  let modalType = 1; // 1: block, 2: delete;
  let data = {};

  $('.btn-user-block, .btn-user-unblock').on('click', function(e) {
    console.log($(this).attr('class'));
    let title = 'Are you sure you want to block the current user?';
    if ($(this).attr('class').includes('btn-user-unblock')) {
      title = 'Are you sure you want to unblock the current user?';
    }
    const url = $(this).data('url');
    const method = $(this).data('method');
    const token = $(this).data('token');
    modalType = 1;
    data = { url, method, token };
    $('#modalBodyText').html(title);
    // userBlockDeleteModal.show();
    $('#userBlockDeleteModal').modal('show');
  });
  $('.btn-user-delete').on('click', function(e) {
    console.log($(this).data('url'));
    const url = $(this).data('url');
    const method = $(this).data('method');
    const token = $(this).data('token');
    const redirectUrl = $(this).data('redirect-url');
    modalType = 2;
    data = { url, method, token, redirectUrl };
    $('#modalBodyText').html('Are you sure you want to delete the current user?');
    // userBlockDeleteModal.show();
    $('#userBlockDeleteModal').modal('show');
  });
  $('#confirmUserBlockDelete').on('click', function(){
    $.ajax({
      type: data.method,
      url: data.url,
      data: { _token: data.token },
      success: function(result) {
        handleResult(result);
      },
      error: function(result) {
        initValues();
        $('#userBlockDeleteModal').modal('hide');
        showToast('error', result.statusText);
      },
    });
  });
  const handleResult = (result) => {
    if (modalType === 1) {
      initValues();
      window.location.reload();
    } else if (modalType === 2) {
      console.log(result);
      if (result.type === 'error') {
        $('#userBlockDeleteModal').modal('hide');
        initValues();
        showToast('error', result.msg);
      } else {
        $('#userBlockDeleteModal').modal('hide');
        window.location.href = data.redirectUrl;
        initValues();
        // showToast('success', result.msg);
      }
    }
  };
  const initValues = () => {
    data = {};
    modalType = 1;
  };
});

function showToast(type, msg) {
  const msgTypes = {error: 'error', info: 'info', success: 'success', warning: 'warning'};
  const msgType = msgTypes[type] || 'info';
  toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
  };
  toastr[msgType](msg);
}
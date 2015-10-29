jQuery(function($) {
  $.mask.definitions['~']='[+-]';
  $('.phone-input').mask('+375 (99) 999-99-99');
});
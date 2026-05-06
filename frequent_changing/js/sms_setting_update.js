(function () {
    function toggleSections(providerSelect) {
      let selected = providerSelect.value;
      if (!selected) {
        selected = providerSelect.dataset.initial;
      }
      document.querySelectorAll('.div_hide').forEach(el => el.style.display = 'none');
      document.querySelectorAll('.show_text').forEach(el => el.textContent = '');
      if (selected) {
        document.querySelectorAll('.div_' + selected).forEach(target => {
          target.style.display = '';
        });
        const option = providerSelect.querySelector('option[value="' + selected + '"]');
        if (option && option.dataset.signup_url) {
          document.querySelectorAll('.show_text').forEach(el => {
            el.innerHTML = ' (<a target="_blank" href="' + option.dataset.signup_url + '">' + (option.dataset.text_singup || '') + ' ' + option.dataset.signup_url + '</a>)';
          });
        }
      }
    }

  const bootstrap = function () {
    const providerSelect = document.querySelector('.sms_service_provider');
    if (!providerSelect) {
      return;
    }
    providerSelect.addEventListener('change', () => toggleSections(providerSelect));
    providerSelect.addEventListener('select2:select', () => toggleSections(providerSelect));
    toggleSections(providerSelect);
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootstrap);
  } else {
    bootstrap();
  }
})();

<section class="cg_profile">
    <h1 class="h1 cg_profile__title" data-lang="cg_profile_title">USER ACCOUNT</h1>

    <form class="cg_profile__form">
        <div class="form__group">
            <label class="form__input">
                <span class="input__title" data-lang="cg_profile_country_title">Country:</span>

                <input
                        name="cg_profile_country"
                        type="text"
                        class="input"
                        value="{{$address['country']}}"
                >
            </label>
        </div>

        <div class="form__group">
            <label class="form__input">
                <span class="input__title" data-lang="cg_profile_email_title">Your mail:</span>

                <input
                        name="cg_profile_email"
                        type="email"
                        class="input"
                        value="{{$legal['email']}}"
                >
            </label>
        </div>

        <div class="form__group">
            <label class="form__input">
                <span class="input__title" data-lang="cg_profile_phone_title">Your phone number:</span>

                <input
                        name="cg_profile_phone"
                        type="tel"
                        class="input"
                        value="{{$legal['phone']}}"
                >
            </label>
        </div>

        <div class="form__group">
            <span class="input__title">Profile type</span>
            <label class="cg_radio_component">
                <input
                        class="input"
                        type="radio"
                        name="cg_profile_type"
                        value="priv"
                        @if (($legal['form'] ?? null) == '1')
                            checked="true"
                        @endif
                >
                <span class="radio"></span>
                <span data-lang="cg_profile_type_priv_title">Personal</span>
            </label>
            <label class="cg_radio_component">
                <input
                        class="input"
                        type="radio"
                        name="cg_profile_type"
                        value="org"
                        @if (($legal['form'] ?? null) == '2')
                            checked="true"
                        @endif
                >
                <span class="radio"></span>
                <span data-lang="cg_profile_type_org_title">For business</span>
            </label>
        </div>

        <div class="form__group">
            <label class="form__input">
                <span class="input__title" data-lang="cg_profile_address_title">Enter company address:</span>

                <input
                        name="cg_profile_address"
                        type="text"
                        class="input"
                        value="{{$address['address']}}"
                >
            </label>
        </div>

        <div class="form__group">
            <label class="input-component form__input">
                <span class="input__title" data-lang="cg_reg_company_title">Name of the company in the documents:</span>

                <input
                        name="cg_company"
                        id="cg_company"
                        type="text"
                        class="input"
                        value="{{$legal['company']}}"
                >
            </label>
        </div>

        <div class="form__group">
            <label class="input-component form__input">
                <span class="input__title" data-lang="cg_reg_inn_title">Company ID:</span>

                <input
                        name="cg_inn"
                        id="cg_inn"
                        type="number"
                        class="input"
                        value="{{$legal['inn']}}"
                >
            </label>
        </div>

        <div class="form__group">
            <label class="input-component form__input">
                <span class="input__title" data-lang="cg_reg_trade_mark_title">Brand Name:</span>

                <input
                        name="cg_trade_mark"
                        id="cg_trade_mark"
                        type="text"
                        class="input"
                        value="{{$legal['trade_mark']}}"
                >
            </label>
        </div>

        <div class="form__group">
            <label class="input-component form__input">
                <span class="input__title" data-lang="cg_reg_slogan_title">Your brand slogan:</span>

                <input
                        name="cg_slogan"
                        type="text"
                        id="cg_slogan"
                        class="input"
                        value="{{$legal['slogan']}}"
                >
            </label>
        </div>

        <div class="form__group">
            <button
                    class="btn btn-lg purple rounded-pill"
                    type="button"
                    data-lang="cg_profile_button_save"
                    onclick="editProfile()"
            >
                Save
            </button>
        </div>
    </form>

    <div class="cg_profile_notify"></div>
</section>

<script>
  let notifications = [];

  const templateNotify = (data, index) => {
    return `
            <div class="notification ${ data.status }_msg" data-notify="${ index }">${ data.message }</div>
        `;
  };

  const editProfile = () => {
    let form = document.querySelector('.cg_profile__form');
    const formData = new FormData(form);

    formData.append('action', 'cgsrv_edit_profile');

    const data = {};
    formData.forEach((value, key) => data[key] = value);

    jQuery.ajax({
      type: 'POST',
      url: '/wp-admin/admin-post.php',
      data: data,
      success: function() {
        notify('success', 'Your data has been saved!');
      },
      error: function() {
        notify('error', 'Save error!');
      }
    });
  };

  let notify = (status, message) => {
    notifications.push({ status, message });

    _render(notifications, 'cg_profile_notify', templateNotify);

    setTimeout(() => {
      const notify = document.querySelector('.cg_profile_notify');
      notify.innerHTML = '';
      notifications = [];
    }, 3000);
  };

  const _render = (data, selector, template) => {
    const block = document.querySelector(`.${ selector }`);
    block.innerHTML = '';

    if(data) {
      data.forEach((prize, index) => block.innerHTML += template(prize, index));
    } else {
      block.innerHTML = template();
    }
  };
</script>

<style>
  @include('../assets/app.css')

  .cg_profile_notify {
    position: fixed;
    top: 40px;
    right: 5px;
  }

  .cg_profile__form {
    max-width: 500px;
  }
</style>

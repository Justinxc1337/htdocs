<section class="cg_create_game">
    <div class="cg_steps"></div>

    <div class="cg_create_game__content"></div>

    <div class="cg_create_game_modal"></div>

    <div class="cg_create_game_notify"></div>
</section>

<script>
  let steps = [
    {
      name: 'Game mechanics',
      action: 'cgsrv_get_create_view',
      id: 'mechanics',
      active: true,
      disabled: false
    },
    {
      name: 'Game templates',
      action: 'cgsrv_get_create_view',
      id: 'choicegame',
      active: false,
      disabled: true
    },
    {
      name: 'Styling',
      action: 'cgsrv_get_create_view',
      id: 'settinggame',
      active: false,
      disabled: true
    },
    {
      name: 'Preview',
      action: 'cgsrv_get_create_view',
      id: 'preview',
      active: false,
      disabled: true
    }
  ];
  let notifications = [];

  let
      templateSteps = (data, index) => {
        return `
            <div
                class="cg_step ${ data.disabled ? 'cg_step_disabled' : '' } ${ data.active ? 'cg_step_active' : '' }"
                onclick="goToStep('${ data.id }', ${ index })"
            >
               ${ data.name }
            </div>
        `;
      },
      templateNotify = (data, index) => {
        return `
            <div class="notification ${ data.status }_msg" data-notify="${ index }">${ data.message }</div>
        `;
      };

  let
      nextStep = (data) => {
        if(data?.name === 'mechanics') {
          getPage('POST', 'cgsrv_get_create_view', 'choicegame');
          localStorage.setItem('cg_stock_type', data.type);
        }

        if(data?.name === 'choicegame') {
          getPage('POST', 'cgsrv_get_create_view', 'settinggame');
          localStorage.setItem('cg_game_id', data.id);
        }

        if(data?.name === 'settinggame') {
          getPage('POST', 'cgsrv_get_create_view', 'preview');
        }
      },
      goToStep = (id, index) => {
        const active_index = steps.findIndex(item => item.active === true);

        if(active_index > index) {
          getPage('POST', 'cgsrv_get_create_view', id);
        }
      },
      getPage = (method, action, id) => {
        const formData = new FormData();
        formData.append('action', action);
        formData.append('cg_create_view_id', id);

        const data = {};
        formData.forEach((value, key) => data[key] = value);

        jQuery.ajax({
          type: method,
          url: '/wp-admin/admin-post.php',
          data: data,
          success: function(data) {
            const step = steps.find(item => item.id === id);
            const active_item = steps.find(item => item.active === true);

            active_item.active = false;
            step.active = true;
            step.disabled = false;

            _render(steps, 'cg_steps', templateSteps);

            document.querySelector('.cg_create_game__content').innerHTML = '';
            document.querySelector('.cg_create_game__content').append(document.createRange().createContextualFragment(data));
          }
        });
      },
      _render = (data, selector, template, render = true) => {
        const block = document.querySelector(`.${ selector }`);
        block.innerHTML = '';

        if(render) {
          if(data) {
            data.forEach((prize, index) => block.innerHTML += template(prize, index));
          } else {
            block.innerHTML = template();
          }
        }
      },
      closeModal = () => {
        const modal = document.querySelector('.cg_modal-mask');
        modal.remove();
      };

  let notify = (status, message) => {
    notifications.push({ status, message });

    _render(notifications, 'cg_create_game_notify', templateNotify);

    setTimeout(() => {
      const notify = document.querySelector('.cg_create_game_notify');
      notify.innerHTML = '';
      notifications = [];
    }, 3000);
  };

  window.onload = () => {
    localStorage.clear();
    getPage('POST', 'cgsrv_get_create_view', 'mechanics');
    _render(steps, 'cg_steps', templateSteps);
  };
</script>

<style>
  @include('../assets/app.css')

  .cg_create_game {
    padding-right: 20px;
    position: relative;
  }

  .cg_create_game_notify {
    position: fixed;
    top: 40px;
    right: 5px;
  }

  .cg_steps {
    display: flex;
    align-items: center;
    gap: 30px;
    font-size: 16px;
    padding: 20px 0;
    border-bottom: 1px solid lightgray;
  }

  .cg_step {
    cursor: pointer;
    transition: color .25s linear;
  }

  .cg_step:hover {
    color: #8a60ff;
  }

  .cg_step.cg_step_active {
    color: #8a60ff;
  }

  .cg_step.cg_step_disabled {
    color: #888888;
    cursor: not-allowed;
  }
</style>

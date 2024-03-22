<section class="cg_my-games">
    <ul class="cg_pagination"></ul>
</section>

<script>
  var
      _PAGE = 1,
      _CG_PACKAGE_TARIFF_ID = 0,
      _CG_ACTIVE_GAMES = 0;

  const templatePagination = (data) => {
    return `
            <div
                class="cg_page-item ${ data.active ? 'cg_active' : '' }"
                onclick="getData(action, '${ data.label }', 20, options)"
            >
                ${ data.label === 'pagination.previous' ? '&#8678;' : data.label === 'pagination.next' ? '&#8680;' : data.label }
            </div>
        `;
  };

  const _render = (data, selector, template, render = true) => {
    const block = document.querySelector(`.${ selector }`);
    block.innerHTML = '';

    if(render) {
      if(data) {
        data.forEach((item, index) => block.innerHTML += template(item, index));
      } else {
        block.innerHTML = template();
      }
    }
  };

  const getData = (action, page = 1, per_page = 20, ...args) => {
    const formData = new FormData();
    formData.append('action', action);
    formData.append('cg_page', String(page));
    formData.append('cg_per_page', String(per_page));

    if(args.length) {
      for(const prop in args[0]) {
        formData.append(prop, args[0][prop]);
      }
    }

    const data = {};
    formData.forEach((value, key) => data[key] = value);

    jQuery.ajax({
      type: 'POST',
      url: '/wp-admin/admin-post.php',
      data: data,
      success: function(res) {
        const response = JSON.parse(res);
        const data = response?.data;
        const links = response?.meta?.links;

        _PAGE = page;

        _render(data, loadingBlock, template);
        _render(links, 'cg_pagination', templatePagination);

        if(data) {
          jQuery.ajax({
            type: 'POST',
            url: '/wp-admin/admin-post.php',
            data: {
              action: 'cg_user_limits'
            },
            success: function(res) {
              const response = JSON.parse(res);
              const data = response?.data[0];
              _CG_PACKAGE_TARIFF_ID = data.package_tariff_id;
            }
          });

          jQuery.ajax({
            type: 'POST',
            url: '/wp-admin/admin-post.php',
            data: {
              action: 'cg_games_by_status',
              cg_game_status: 'active'
            },
            success: function(res) {
              const response = JSON.parse(res);
              _CG_ACTIVE_GAMES = response?.meta?.total;
            }
          });
        }
      }
    });
  };

  window.onload = () => {
    getData(action);
  };
</script>

<style>
  .cg_pagination {
    box-shadow: 0 4px 4px rgba(0, 0, 0, .25);
    margin: 20px 0 0 0;
    display: inline-flex;
  }

  .cg_pagination .cg_page-item {
    cursor: pointer;
    text-align: center;
    background-color: #fff;
    border-top: 1px solid #8a60ff;
    border-bottom: 1px solid #8a60ff;
    border-left: 1px solid #8a60ff;
    color: #8a60ff;
    display: block;
    line-height: 1.25;
    padding: 8px 12px;
    position: relative;
    transition: all .25s linear;
  }

  .cg_pagination .cg_page-item:first-child {
    border-radius: 4px 0 0 4px;
  }

  .cg_pagination .cg_page-item:last-child {
    border-right: 1px solid #8a60ff;
    border-radius: 0 4px 4px 0;
  }

  .cg_pagination .cg_page-item.cg_active {
    background-color: #8a60ff;
    border-color: #8a60ff;
    color: #fff;
  }

  .cg_page-item:hover {
    background-color: #e9ecef;
    border-color: #dee2e6 !important;
    color: #8a60ff;
    z-index: 2;
  }
</style>

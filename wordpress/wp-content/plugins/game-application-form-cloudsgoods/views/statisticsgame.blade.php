<section class="cg_statistic">
    <h1 class="cg_statistic__title" data-lang="cg_statistic_title">Game statistics</h1>

    <div class="cg_statistic__tabs">
        <div class="switch-buttons">
            <button
                    class="switch-button active"
                    onclick="getReceived('today')"
                    data-received="all"
            >
                Today
            </button>

            <button
                    class="switch-button"
                    onclick="getReceived('week')"
                    data-received="yes"
            >
                Week
            </button>

            <button
                    class="switch-button"
                    onclick="getReceived('month')"
                    data-received="not"
            >
                Month
            </button>

            <button
                    class="switch-button"
                    onclick="getReceived('all')"
                    data-received="not"
            >
                All
            </button>
        </div>

        <div class="cg_statistic__calendars">
            <label>
                <input type="date" onchange="onFrom(event)">
            </label>
            <div class="delimiter"></div>
            <label>
                <input type="date" onchange="onTo(event)">
            </label>
        </div>
    </div>

    <div class="statistics-controller__table"></div>

    <div class="cg_statistic__modal"></div>
</section>

<script>
  const action = 'cgsrv_prize_list';
  const loadingBlock = 'rows_group';
  const options = { cg_received: 'all', from: '', to: '' };

  const headers = {
    emails: 'Number of collected email contacts',
    phones: 'Number of collected phone numbers',
    players: 'Number of visitors who played the game',
    referals: 'Number of referred users by other players',
  };

  const template = (data) => {
    return `
        <div class="statistics-controller__tr">
            <div class="statistics-controller__td">Количество посетителей сыгравших в игру</div>
            <div class="statistics-controller__td">0</div>
        </div>
      `;
  };

  const
      giveOut = (id) => {
        const formData = new FormData();
        formData.append('action', 'cgsrv_issue_prize');
        formData.append('cg_prize_id', id);

        const data = {};
        formData.forEach((value, key) => data[key] = value);

        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: data,
          success: function() {
            _render([JSON.parse(res).data], '', )
          }
        });
      },
      getReceived = (cg_received) => {
        options.cg_received = cg_received;
        const switchButton = document.querySelectorAll('.switch-button');
        switchButton.forEach(item => {
          item.classList.remove('active');

          if(item.dataset.received === cg_received) {
            item.classList.add('active');
          }
        });
      },
      onFrom = (e) => {
        options.from = e.target.value;
      },
      onTo = (e) => {
        options.to = e.target.value;
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
</script>

<style>
  @include('../assets/app.css')
  .cg_statistic {
    padding-right: 20px;
  }

  @media (max-width: 782px) {
    .cg_statistic {
      padding-right: 10px;
    }
  }

  .cg_statistic__title {
    font-size: 40px;
    line-height: 1;
    font-weight: bold;
    color: #8a60ff;
    text-transform: uppercase;
  }

  .cg_statistic__search {
    width: 100%;
    max-width: 500px;
    margin-top: 10px;
  }

  .btn {
    width: 100%;
    min-height: 25px;
    height: unset;
    padding: 6px 12px;
    font-size: 11px;
    border-radius: 70px;
  }

  .switch-buttons {
    background-color: #dadada;
    border-radius: 50px;
    display: inline-block;
    cursor: pointer;
  }

  .switch-buttons .switch-button {
    width: auto;
    display: inline-block;
    background-color: transparent;
    border-radius: 50px;
    padding: 10px 30px;
    font-weight: 700;
    font-size: 12px;
    color: #000;
    transition: all .25s linear;
    border: none;
    outline: none;
    cursor: pointer;
  }

  .switch-buttons .switch-button.active {
    background-color: #808080;
    color: #fff;
  }
</style>

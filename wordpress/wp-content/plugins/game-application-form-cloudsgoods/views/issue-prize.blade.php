<section class="cg_prizes">
    <h1 class="cg_prizes__title" data-lang="cg_prizes_title">GIVE PRIZES</h1>

    <div class="cg_prizes__tabs">
        <div class="switch-buttons">
            <button
                    class="switch-button active"
                    onclick="getReceived('all')"
                    data-received="all"
            >
                All
            </button>

            <button
                    class="switch-button"
                    onclick="getReceived('yes')"
                    data-received="yes"
            >
                Issued
            </button>

            <button
                    class="switch-button"
                    onclick="getReceived('not')"
                    data-received="not"
            >
                Not issued
            </button>
        </div>
    </div>

    <div class="cg_prizes__search">
        <label>
            <input name="cg_prizes_search" type='text' placeholder="Search by coupon number" onchange="getSearch(event)">
        </label>
    </div>

    <div class="scrollbar">
        <div class="table list">
            <div class="th">
                <div class="td" data-lang="cg_prizes_table_email">E-Mail</div>
                <div class="td" data-lang="cg_prizes_table_phone">Phone number</div>
                <div class="td" data-lang="cg_prizes_table_phone">Name</div>
                <div class="td" data-lang="cg_prizes_table_phone">Amount</div>
                <div class="td" data-lang="cg_prizes_table_coupon">Coupon number</div>
                <div class="td" data-lang="cg_prizes_table_status">Status</div>
                <div class="td" data-lang="cg_prizes_table_date">Validity (days)</div>
            </div>
            <div class="rows_group"></div>
        </div>
    </div>

    <div class="cg_prizes__modal"></div>

    @include('../assets/include/pagination.blade.php')
</section>

<script>
  const action = 'cgsrv_prize_list';
  const loadingBlock = 'rows_group';
  const options = { cg_received: 'all', cg_filter: '' };

  const
      template = (data) => {
        return `
        <div class="tr">
            <div class="td">${ data.user ? data.user.email : '-' }</div>

            <div class="td">${ data.user ? data.user.phone : '-' }</div>

            <div class="td">${ data.coupon ? data.coupon.prize.name : '-' }</div>

            <div class="td">${ data.coupon ? data.coupon.prize.price : '-' }</div>

            <div class="td">${ data?.coupon?.coupon_number }</div>

            <div class="td">
                ${ data.received ? `
                    <button
                            class="btn disabled"
                            type="button"
                            data-lang="cg_prizes_table_received"
                    >
                        Issued
                    </button>
                ` : `
                    <button
                            class="btn"
                            type="button"
                            data-lang="cg_prizes_table_received_not"
                            onclick="openModalGiveOut(
                                {
                                prize_name: '${ data.coupon ? data.coupon.prize.name : '-' }',
                                coupon_number: '${ data?.coupon?.coupon_number }',
                                phone: '${ data.user ? data.user.phone : '-' }',
                                price: '${ data.coupon ? data.coupon.prize.price : '-' }',
                                id: '${ data.id }'
                                }
                            )"
                    >
                        Not issued
                    </button>
                ` }
            </div>

            <div class="td">${ data.coupon ? data.coupon.prize.number_days : '-' }</div>
        </div>
      `;
      },
      templateModalGiveOut = (data) => {
        return `
            <div class="cg_modal-mask">
                <div class="cg_modal-wrapper" onclick="closeModal()"></div>
                <div class="cg_modal-container">
                    <div class="cg_modal-header">
                        <div class="title">Prize giveaway</div>
                        <button type="button" class="cg_close" onclick="closeModal()">×</button>
                    </div>
                    <div class="cg_modal-body">
                        <div class="cg_modal-body_content">
                            <p>
                                <strong>PRIZE NAME</strong>
                                <br>
                                <span>${ data.prize_name }</span>
                            </p>

                            <p>
                                <strong>COUPON NUMBER</strong>
                                <br>
                                <span>${ data.coupon_number }</span>
                            </p>

                            <p>
                                <strong>WINNER’S CONTACT</strong>
                                <br>
                                <span>${ data.phone }</span>
                            </p>

                            <p>
                                <strong>PRIZE</strong>
                                <br>
                                <span>${ data.price }</span>
                            </p>

                            <button type="button" class="btn purple"  onclick="giveOut('${ data.id }')">Giving out the prize</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
      };

  const
      openModalGiveOut = (data) => {
        _render([data], 'cg_prizes__modal', templateModalGiveOut);
      },
      closeModal = () => {
        const modal = document.querySelector('.cg_modal-mask');
        modal.remove();
      },
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
            getData(action, _PAGE, 20, options);
            closeModal();
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

        getData(action, 1, 20, options);
      },
      getSearch = (cg_filter) => {
        options.cg_filter = cg_filter.target.value;

        getData(action, 1, 20, options);
      };
</script>

<style>
  @include('../assets/app.css')
  .cg_prizes {
    padding-right: 20px;
  }

  @media (max-width: 782px) {
    .cg_prizes {
      padding-right: 10px;
    }
  }

  .cg_prizes__title {
    font-size: 40px;
    line-height: 1;
    font-weight: bold;
    color: #8a60ff;
    text-transform: uppercase;
  }

  .cg_prizes__search {
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

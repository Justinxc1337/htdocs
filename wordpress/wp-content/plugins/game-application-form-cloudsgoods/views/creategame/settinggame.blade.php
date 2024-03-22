<div class="cg_setting_game">
    <form class="cg_setting_game__form" autocomplete="off">
        <div class="cg_setting_game__visual">
            <h3 class="cg_setting_game__title">1. Now let's set up the visual part of the game!</h3>

            <div class="cg_setting_game__visual__goods">
                <p class="cg_setting_game__subtitle">
                    Upload the items or photos that you want to show in the game. For example, the hero of the game will
                    run and collect these goods and get points for them.
                </p>

                <div class="cg_setting_game__visual__goods__logo">
                    <div>
                        <button
                                type="button"
                                class="btn custom-button button orange"
                                onclick="openModalUpload('cg_goods')"
                        >
                            Select from uploaded items
                        </button>

                        <button
                                type="button"
                                class="btn custom-button button"
                                onclick="openModal('cg_goods')"
                        >
                            Upload your items
                        </button>
                    </div>

                    <div class="cg_setting_game__visual__goods__preview"></div>
                </div>
            </div>

            <div class="cg_setting_game__visual__logotype">
                <p class="cg_setting_game__subtitle">Upload your logo to show up in the game</p>

                <div class="cg_setting_game__visual__logotype__logo"></div>
            </div>

            <div class="cg_prizes">
                <h3 class="cg_setting_game__title cg_prizes__title"></h3>

                <div class="cg_prizes__content"></div>

                <div class="cg_prizes__footer">
                    <button
                            type="button"
                            class="btn"
                            onclick="addPrize()"
                    >
                        Add a prize
                    </button>

                    <button
                            type="button"
                            class="btn outline purple"
                            onclick="addPrize(true)"
                    >
                        Add a prize incentive
                    </button>
                </div>
            </div>

            <h3 class="cg_setting_game__title">3. Write a company slogan</h3>

            <div class="cg_slogan">
                <label class="cg_input">
                    <textarea cols="60" rows="5" class="cg_textarea" onchange="changeSlogan()">Win prizes with us!</textarea>
                </label>
            </div>

            <h3 class="cg_setting_game__title">4. What contacts do you want to collect using the widget?</h3>

            <div class="cg_collections">
                <label class="cg_radio_component">
                    <input
                            class="input"
                            type="radio"
                            name="cg_collection"
                            value="phone"
                            checked
                            onchange='changeCollection(event.target.value)'
                    >
                    <span class="radio"></span>
                    Phone numbers
                </label>

                <label class="cg_radio_component">
                    <input
                            class="input"
                            type="radio"
                            name="cg_collection"
                            value="email"
                            onchange='changeCollection(event.target.value)'
                    >
                    <span class="radio"></span>
                    E-mail
                </label>
            </div>

            <h3 class="cg_setting_game__title">5. When to launch of the game?</h3>

            <div class="cg_launch">
                <div class="cg_launch_top">
                    <label class="cg_radio_component">
                        <input
                                class="input"
                                type="radio"
                                name="cg_date"
                                value="1"
                                checked
                                onchange="showCalendar(event, 1)"
                        >
                        <span class="radio"></span>
                        Immediately
                    </label>

                    <label class="cg_radio_component">
                        <input
                                class="input"
                                type="radio"
                                name="cg_date"
                                value="2"
                                onchange="showCalendar(event, 2)"
                        >
                        <span class="radio"></span>
                        Delayed start
                    </label>
                </div>

                <div class="cg_launch_body">
                    <div class="cg_launch_calendar"></div>

                    <p class="cg_setting_game__subtitle">
                        Specify the number of days of game activity (as soon as the period expires, the widget will stop
                        displaying the game, but you can always create a new game or to restart the old one)
                    </p>

                    <label class="cg_input_group">
                        <input
                                name="cg_date_quantity"
                                type="number"
                                min="1"
                                class="input"
                                value="1"
                                onchange='changeQuantityDay(event.target.value)'
                        >
                        <span class="cg_input_group_append">days</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="cg_setting_game__button">
            <button type="button" class="btn purple" onclick="saveData()">Next</button>
        </div>
    </form>
</div>

<script>
  var
      prizes = [
        {
          cg_games_prizes_type_id: '1',
          cg_prize_value: 0,
          cg_prize_currency: 'rub',
          cg_start_place: 1,
          cg_end_place: 1,
          cg_incentive_prize: false,
          cg_quantity: 1,
          cg_good_name: '',
          cg_good: null,
          cg_lucky_prize: 1
        }
      ],
      cg_prizes_good_preview = [],
      calendar = [
        {
          subtitle: 'Select the start date of the game:',
          name: 'cg_calendar',
          value: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().slice(0, -1).slice(0, new Date().toISOString().lastIndexOf(':'))
        }
      ],
      cg_day = 1,
      cg_collection = 'phone',
      cg_date = 1,
      logotype = null,
      logotype_file = null,
      cg_slogan = 'Win prizes with us!',
      cg_goods = [],
      cg_goods_preview = [],
      cg_goods_upload_preview = null,
      cg_goods_upload = null,
      mechanic_type = localStorage.getItem('cg_stock_type'),
      uploadGoodsData = null,
      uploadGoodsDataSelected = [];

  var
      templateGoodsPreview = (data, index) => {
        return `
            <div class="cg_setting_game__visual__goods__wrapper">
                <!--These are dynamically added pictures, and we get them through the API. Therefore, we cannot transfer them to plugin files.-->
                <img src="https://cloudsgoods.com${ data }" alt="preview"/>
                <button type="button" onclick="removeGoods(${ index })" class="btn">&#x2715;</button>
            </div>
        `;
      },
      templateLogotype = () => {
        return `
            <label class="cg_input_component">
                <input
                    accept="image/*"
                    name="cg_setting_game_logotype"
                    type="file"
                    class="input"
                    onchange="changeLogotype(event)"
                >

                <span class="cg_image">
                    ${ logotype ? `<img src="${ logotype }" alt="Logotype">` : '<span class="cg_box">+</span>' }
                </span>
            </label>
        `;
      },
      templatePrizeTitle = () => {
        return `
            ${ mechanic_type === 'viral' ? `
                <span>2. Now you need to set up gifts for those who will play the game widget! In this mechanic there is a table of results. The first place winner will win the main prize. Add prizes for other places as well, or add an incentive prize to keep everyone interested in playing your game.</span>
            ` : mechanic_type === 'ordinal' ? `
                <span>2. Now you need to set up gifts for those who will play the game widget! In this mechanic, gifts fall in the game only to those who play under a certain number. For example, the player played 15th in the list, and you have a prize for 15th place. Consequently, this player played under the lucky number.</span>
            ` : mechanic_type === 'fast' ? `
                <span>2. Now you need to set up gifts for those who will play the game widget! Gifts are won randomly, the player doesn't know what they'll get until they play. Specify the number of prizes, if all the prizes drawn run out, the game will pause.</span>
            ` : '' }
        `;
      },
      templatePrize = (data, index) => {
        return `
        <div class="cg_prize">
          <div class="cg_prize__wrapper">
              ${ !data.cg_incentive_prize ? `
                  <h3 class="cg_prize__title">${ index === 0 ? 'Main gift' : 'Gift №' + (index + 1) }</h3>
              ` : `<h3 class="cg_prize__title">Incentive prize</h3>` }

              ${ mechanic_type === 'viral' ? `
                  ${ !data.cg_incentive_prize ? `
                      <div class="cg_prize__place">
                          <span>Place from</span>
                          <input
                              type="number"
                              name="cg_start_place"
                              min="1"
                              value="${ data.cg_start_place }"
                              disabled
                              onchange='changePrize(event, "cg_start_place", ${ index })'
                          >
                          <span>to</span>
                          <input
                              type="number"
                              name="cg_end_place"
                              min="1"
                              value="${ data.cg_end_place }"
                              ${ prizes.length - 1 > index ? 'disabled' : '' }
                              onchange='changePrize(event, "cg_end_place", ${ index })'
                          >
                      </div>
                  ` : `` }
              ` : `` }

              ${ mechanic_type === 'ordinal' ? `
                  <div class="cg_prize__place">
                      <div class="cg_prize__place_wrap">
                          <span>Enter the lucky number of the player to win this prize</span>

                          <label class="cg_prize__place_full">
                              <input
                                  type="number"
                                  name="cg_lucky_prize"
                                  min="1"
                                  value="${ data.cg_lucky_prize }"
                                  onchange='changePrize(event, "cg_lucky_prize", ${ index })'
                              >
                          </label>
                      </div>
                  </div>
              ` : `` }

              <div class="cg_prize__type">
                  <span>Choose the type of prize</span>
                  <select
                      name="cg_games_prizes_type_id"
                      onchange='changePrize(event, "cg_games_prizes_type_id", ${ index })'
                  >
                        <option value="1" ${ data.cg_games_prizes_type_id === '1' ? 'selected' : '' }>Gift Certificate</option>
                        <option value="2" ${ data.cg_games_prizes_type_id === '2' ? 'selected' : '' }>Discount coupon</option>
                        <option value="3" ${ data.cg_games_prizes_type_id === '3' ? 'selected' : '' }>Cash award</option>
                        <option value="4" ${ data.cg_games_prizes_type_id === '4' ? 'selected' : '' }>Your item</option>
                  </select>
              </div>

              ${ data.cg_games_prizes_type_id === '4' ? `
                <div class="cg_prize__good">
                    <div class="cg_prize__good__name">
                        <span>Gift Name</span>
                        <input
                            type="text"
                            name="cg_good_name"
                            value="${ data.cg_good_name }"
                            onchange='changePrize(event, "cg_good_name", ${ index })'
                        >
                    </div>

                    ${ cg_prizes_good_preview[index]?.url ? `
                        <div class="cg_prize__good__image">
                           <!--These are dynamically added pictures, and we get them through the API. Therefore, we cannot transfer them to plugin files.-->
                           <img src="https://cloudsgoods.com${ cg_prizes_good_preview[index]?.url }" alt="Logotype">

                           <span onclick="removeGoodToPrize('cg_good', ${ index })" class="btn purple">&#x2715;</span>
                        </div>
                    ` : '' }


                    <div class="cg_prize__good__actions">
                        <button type="button" class="btn courier-desc" onclick="openModalUpload('cg_good', ${ index })"><small>Choose a product</small></button>
                        <button type="button" class="btn purple outline courier-desc" onclick="openModal('cg_good', ${ index })"><small>Upload item</small></button>
                    </div>
                </div>
              ` : `` }

              ${ mechanic_type === 'fast' ? `
                  <div class="cg_prize__place">
                      <div class="cg_prize__place_wrap">
                          <span>Enter the total number of prizes to be won</span>

                          <label class="cg_input_group">
                              <input
                                  type="number"
                                  name="cg_quantity"
                                  min="1"
                                  value="${ data.cg_quantity }"
                                  onchange='changePrize(event, "cg_quantity", ${ index })'
                              >
                              <span class="cg_input_group_append">pcs</span>
                          </label>
                      </div>
                  </div>
              ` : `` }

              <div class="cg_prize__amount">
                <span>Amount</span>
                <label class="cg_input_group">
                    ${ data.cg_games_prizes_type_id === '2' ? `
                        <input
                            name="cg_prize_value"
                            type="number"
                            min="1"
                            max="100"
                            value="${ data.cg_prize_value > 100 ? data.cg_prize_value = 100 : data.cg_prize_value }"
                            onchange='changePrize(event.target.value > 100 ? event.target.value = 100 : event, "cg_prize_value", ${ index })'
                        >
                        <span class="cg_input_group_append">%</span>
                    ` : `
                        <input
                            name="cg_prize_value"
                            type="number"
                            min="1"
                            value="${ data.cg_prize_value }"
                            onchange='changePrize(event, "cg_prize_value", ${ index })'
                        >
                        <div class="cg_input_group_select">
                            <select name="cg_prize_currency" onchange='changePrize(event, "cg_prize_currency", ${ index })' class="cg_form-control">
                                <option value="rub" ${ data.cg_prize_currency === 'rub' ? 'selected' : '' }>RUB</option>
                                <option value="usd" ${ data.cg_prize_currency === 'usd' ? 'selected' : '' }>USD</option>
                                <option value="euro" ${ data.cg_prize_currency === 'euro' ? 'selected' : '' }>EURO</option>
                            </select>
                        </div>
                    ` }
                </label>
              </div>

              ${ data.cg_games_prizes_type_id === '4' ? `
                  <div class="cg_prize__notify">When adding an item prize draw, you will need to <br/> contact the winner yourself and give him/her the prize</div>
              ` : `` }

              ${ index !== 0 && prizes.length - 1 === index ? `<div class="cg_prize__actions">
                  <span onclick="removePrize(${ index })">Delete</span>
              </div>` : '' }
          </div>
        </div>
      `;
      },
      templateCalendar = (data, index) => {
        return `
            <p class="cg_setting_game__subtitle">${ data.subtitle }</p>
            <label>
              <input
                  type="datetime-local"
                  name="${ data.name }"
                  onchange='changeCalendar(event.target.value, ${ index })'
                  min="${ (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().slice(0, -1).slice(0, new Date().toISOString().lastIndexOf(':')) }"
                  value="${ (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().slice(0, -1).slice(0, new Date().toISOString().lastIndexOf(':')) }"
              >
            </label>
        `;
      },
      templateModalLoadGoodImage = (data) => {
        return `
            <div class="input-component">
                <label class="cg_input_component">
                    <input
                        accept="image/*"
                        name="cg_image"
                        type="file"
                        class="input"
                        onchange="uploadGood(event, '${ data.key }')"
                    >

                    <span class="cg_image">
                        ${ cg_goods_upload_preview ? `<img src="${ cg_goods_upload_preview }" alt="Upload Good">` : '<span class="cg_box">+</span>' }
                    </span>
                </label>
            </div>
        `;
      },
      templateModalLoadGood = (data) => {
        return `
            <div class="cg_modal-mask">
                <div class="cg_modal-wrapper" onclick="closeModal()"></div>
                <div class="cg_modal-container">
                    <div class="cg_modal-header">
                        <div class="title">Upload item</div>
                        <button type="button" class="cg_close" onclick="closeModal()">×</button>
                    </div>
                    <div class="cg_modal-body">
                        <form data-id="loadGood">
                            <div class="cg_fields">
                                <div class="subtitle">Fill in all fields to load the item</div>
                                <div class="input-form-element inputs">
                                    <div class="input-component">
                                        <div class="title">Enter name of the item</div>
                                        <label class="body">
                                            <input name="cg_title" type="text" class="input">
                                        </label>
                                    </div>

                                    <div class="input-component">
                                        <div class="title">Enter a link to the item</div>
                                        <label class="body">
                                            <input name="cg_link" type="text" class="input">
                                        </label>
                                    </div>

                                    <div class="input-component">
                                        <div class="title">Enter dollar value of the item</div>
                                        <label class="body">
                                            <input name="cg_price" type="number" class="input" min="0">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="cg_img-wrapper"></div>
                        </form>
                    </div>
                    <div class="cg_modal-footer">
                        <button type="button" class="btn purple outline btn-cg" onclick="saveLoadedGood('${ data.key }', ${ data.index })">Save</button>
                    </div>
                </div>
            </div>
        `;
      },
      templateModalUploadGood = () => {
        return `
            <div class="cg_modal-mask">
                <div class="cg_modal-wrapper" onclick="closeModal()"></div>
                <div class="cg_modal-container cg_upload_good_container">
                    <div class="cg_modal-header">
                        <div class="title">Choose a product</div>
                        <button type="button" class="cg_close" onclick="closeModal()">×</button>
                    </div>
                    <div class="cg_modal-body cg_upload_good"></div>
                </div>
            </div>
        `;
      },
      templateModalUploadGoodItem = (data) => {
        return `
            <div
                class="cg_upload_good_image"
                onclick="checkGoodsBlock('${ data.id }', '${ data.photo_uri }', '${ data.key }', '${ data.index }')"
            >
                <!--These are dynamically added pictures, and we get them through the API. Therefore, we cannot transfer them to plugin files.-->
                <img src="https://cloudsgoods.com${ data.photo_uri }" alt="${ data.title }">
            </div>
        `;
      };

  var
      addPrize = (incentive = false) => {
        let lastPrize = prizes[prizes.length - 1];
        let filtered;

        if(!prizes[prizes.length - 1].cg_incentive_prize) {
          filtered = prizes[prizes.length - 1];
        } else {
          filtered = prizes[prizes.length - 2];
        }

        const incentivePrize = prizes.find(item => item.cg_incentive_prize === true);

        if(incentive && incentivePrize) return;

        if(lastPrize.cg_incentive_prize) {
          prizes.splice(prizes.length - 1, 0, {
            cg_games_prizes_type_id: '1',
            cg_prize_value: 0,
            cg_prize_currency: 'rub',
            cg_start_place: Number(filtered.cg_end_place) + 1,
            cg_end_place: Number(filtered.cg_end_place) + 1,
            cg_incentive_prize: incentive,
            cg_good_name: '',
            cg_good: null,
            cg_lucky_prize: 1
          });

          return _render(prizes, 'cg_prizes__content', templatePrize);
        }

        prizes.push({
          cg_games_prizes_type_id: '1',
          cg_prize_value: 0,
          cg_prize_currency: 'rub',
          cg_start_place: Number(filtered.cg_end_place) + 1,
          cg_end_place: Number(filtered.cg_end_place) + 1,
          cg_incentive_prize: incentive,
          cg_good_name: '',
          cg_good: null,
          cg_lucky_prize: 1
        });

        _render(prizes, 'cg_prizes__content', templatePrize);
      },
      addGoodToPrize = (id, image, key, index) => {
        cg_prizes_good_preview[index] = { url: image };
        prizes[index][key] = id;

        _render(prizes, 'cg_prizes__content', templatePrize);
      },
      removePrize = (index) => {
        if(index !== 0) {
          prizes.splice(index, 1);
        }

        _render(prizes, 'cg_prizes__content', templatePrize);
      },
      removeGoodToPrize = (key, index) => {
        cg_prizes_good_preview.splice(index, 1);
        prizes[index][key] = '';
        _render(prizes, 'cg_prizes__content', templatePrize);
      };

  var
      addGoods = (id, image) => {
        if(cg_goods.length < 5) {
          cg_goods_preview.push(image);
          cg_goods.push(id);

          _render(cg_goods_preview, 'cg_setting_game__visual__goods__preview', templateGoodsPreview);
        } else {
          notify('error', 'You can add no more than 5 goods!');
        }
      },
      removeGoods = (index) => {
        cg_goods_preview.splice(index, 1);
        cg_goods.splice(index, 1);

        _render(cg_goods_preview, 'cg_setting_game__visual__goods__preview', templateGoodsPreview);
      };

  var
      checkGoodsBlock = (id, photo_uri, key_, index) => {
        if(key_ === 'cg_goods') {
          addGoods(id, photo_uri, key_);
        } else if(key_ === 'cg_good') {
          addGoodToPrize(id, photo_uri, key_, index);
        }

        closeModal();
      };

  var
      openModal = (key, index) => {
        cg_goods_upload_preview = null;
        _render([{ key, index }], 'cg_create_game_modal', templateModalLoadGood);
        _render([{ key }], 'cg_img-wrapper', templateModalLoadGoodImage);
      },
      openModalUpload = (key, index) => {
        const form = new FormData();
        form.append('action', 'cgsrv_list_goods');
        form.append('cg_page', '1');
        form.append('cg_per_page', '100000');

        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: form,
          enctype: 'multipart/form-data',
          contentType: false,
          processData: false,
          success: function(res) {
            const data = JSON.parse(res).data.map(item => {
              return {
                ...item,
                key,
                index
              };
            });
            _render([{ key }], 'cg_create_game_modal', templateModalUploadGood);
            _render(data, 'cg_upload_good', templateModalUploadGoodItem);
          }
        });
      },
      uploadGood = (e, key) => {
        const
            files = e.target.files || e.dataTransfer.files,
            blob = new Blob([files[0]], { type: files[0].type });

        cg_goods_upload_preview = URL.createObjectURL(blob);
        cg_goods_upload = blob;

        _render([{ key }], 'cg_img-wrapper', templateModalLoadGoodImage);
      },
      saveLoadedGood = (key_, index) => {
        const load_good_form = document.querySelector('[data-id="loadGood"]');
        const form = new FormData(load_good_form);

        for([key, value] of form) {
          if(key === 'cg_image') {
            form.delete(key);
            form.append(key, cg_goods_upload);
          }
        }

        form.append('action', 'cgsrv_create_good');

        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: form,
          enctype: 'multipart/form-data',
          contentType: false,
          processData: false,
          success: function(res) {
            const { id, photo_uri } = JSON.parse(res).data;
            checkGoodsBlock(id, photo_uri, key_, index);
            closeModal();
          }
        });
      };

  var
      changeCollection = (date) => {
        cg_collection = date;
      },
      changeSlogan = (data) => {
        cg_slogan = data;
      },
      changeQuantityDay = (date) => {
        cg_day = date;
      },
      changePrize = (e, key, index) => {
        prizes[index][key] = String(e.target.value);

        if(key === 'cg_games_prizes_type_id') {
          _render(prizes, 'cg_prizes__content', templatePrize);
        }
      },
      changeCalendar = (data, index) => {
        calendar[index].value = data;
      },
      changeLogotype = (e) => {
        const
            files = e.target.files || e.dataTransfer.files,
            blob = new Blob([files[0]], { type: files[0].type });

        logotype = URL.createObjectURL(blob);
        logotype_file = blob;

        _render(null, 'cg_setting_game__visual__logotype__logo', templateLogotype);
      },
      showCalendar = (e) => {
        cg_date = e.target.value;

        if(Number(e.target.value) === 2 && e.target.checked) {
          _render(calendar, 'cg_launch_calendar', templateCalendar);
        } else {
          _render(null, 'cg_launch_calendar', null, false);
        }
      };

  var saveData = () => {
    const formData = new FormData();
    const calendarUnix = new Date(calendar[0].value) / 1000;

    if(!logotype_file && !cg_goods.length) {
      notify('error', 'Download the logo!');
      notify('error', 'Upload your products or services!');
      return;
    }

    if(!logotype_file) {
      notify('error', 'Download the logo!');
      return;
    }

    if(!cg_goods.length) {
      notify('error', 'Upload your products or services!');
      return;
    }

    formData.append('action', 'cgsrv_create_gamestock');
    formData.append('cg_game_id', localStorage.getItem('cg_game_id'));
    formData.append('cg_stock_type', localStorage.getItem('cg_stock_type'));
    formData.append('cg_day', cg_day);
    formData.append('cg_collection', cg_collection);
    formData.append('cg_calendar', JSON.stringify(calendarUnix));
    formData.append('cg_date', cg_date);
    formData.append('cg_logotype', logotype_file);
    formData.append('cg_slogan', cg_slogan);
    formData.append('cg_goods', JSON.stringify(cg_goods));
    formData.append('cg_prizes', JSON.stringify(prizes));

    const data = {};
    formData.forEach((value, key) => data[key] = value);
    localStorage.setItem('cg_setting_game', JSON.stringify(data));

    jQuery.ajax({
      type: 'POST',
      url: '/wp-admin/admin-post.php',
      data: formData,
      enctype: 'multipart/form-data',
      contentType: false,
      processData: false,
      success: function(res) {
        nextStep({ name: 'settinggame' });
        localStorage.setItem('cg_game', JSON.stringify(JSON.parse(res).data));
      }
    });
  };

  _render(null, 'cg_setting_game__visual__logotype__logo', templateLogotype);
  _render(null, 'cg_prizes__title', templatePrizeTitle);
  _render(prizes, 'cg_prizes__content', templatePrize);
</script>

<style>
  @include('../assets/app.css')

  .cg_setting_game__title {
    line-height: 1.4;
    font-weight: 400;
  }

  .cg_setting_game__visual__goods__logo {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
  }

  .btn.custom-button {
    font-size: 12px;
    line-height: 1.3;
    height: 120px;
    background-color: #fff;
    width: 160px;
    border: 1px solid #8a60ff;
    color: #8a60ff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    box-sizing: border-box;
    box-shadow: 0 4px 29px rgba(71, 0, 255, .22);
  }

  .btn.custom-button.orange {
    border-color: #fa9917;
    color: #fa9917;
    box-shadow: 0 4px 29px rgba(250, 153, 23, 0.22);
    white-space: unset;
    margin-bottom: 10px;
  }

  .cg_setting_game__visual__goods__preview {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    height: 125px;
  }

  .cg_setting_game__visual__goods__preview img {
    max-width: 125px;
    max-height: 100%;
  }

  .cg_setting_game__visual__goods__wrapper {
    position: relative;
    display: flex;
  }

  .cg_setting_game__visual__goods__wrapper button {
    top: 5px;
    right: 5px;
    position: absolute;
    padding: 0;
    height: 30px;
    width: 30px;
    background-color: rgba(255, 0, 0, .58) !important;
  }

  .cg_setting_game__visual__goods__wrapper button:hover {
    background-color: rgba(255, 0, 0, 1) !important;
  }

  .cg_setting_game__visual__logotype__logo {
    height: 125px;
    width: 125px;
  }

  .cg_input_component {
    border: 2px dashed #8a60ff;
    border-radius: 10px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, .05);
    height: 100%;
    width: 100%;
    margin-bottom: 0;
    position: relative;
    cursor: pointer;
    display: flex;
  }

  .cg_input_component input {
    display: none;
  }

  .cg_image {
    height: 100%;
    padding: 3px;
    position: relative;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .cg_image img {
    max-width: 100%;
    max-height: 100%;
  }

  .cg_box {
    height: 42px;
    width: 42px;
    border-radius: 50%;
    border: 2px solid #8a60ff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #8a60ff;
  }

  .cg_prizes {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .cg_prizes__content {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  .cg_prize {
    width: 400px;
    border: 1px solid #c4c4c4;
    border-radius: 10px;
    padding: 14px;
  }

  .cg_prize__title {
    font-size: 32px;
    line-height: 1;
    margin: 0;
  }

  .cg_prize__wrapper {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .cg_prize__place {
    padding: 16px 0;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    gap: 10px;
    text-transform: uppercase;
    font-size: 16px;
  }

  .cg_prize__place > span {
    white-space: nowrap;
  }

  .cg_prize__place_wrap {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    color: #8a60ff;
    text-transform: initial;
  }

  .cg_prize__place_wrap input {
    width: 90% !important;
  }

  .cg_prize__place_full input {
    width: 100% !important;
  }

  .cg_prize__type {
    font-size: 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    color: #8a60ff;
  }

  .cg_prize__amount {
    font-size: 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    color: #8a60ff;
  }

  .cg_prize__actions {
    cursor: pointer;
  }

  .cg_prizes__footer {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .cg_launch {
    max-width: 400px;
  }

  .cg_launch_top {
    max-width: 250px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .cg_launch_calendar {
    max-width: 250px;
  }

  .cg_launch .cg_radio_component {
    white-space: nowrap;
    margin-top: 0 !important;
  }

  .cg_launch_date {
    max-width: 150px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .cg_prize__good {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .cg_prize__good__actions {
    display: flex;
    gap: 10px;
  }

  .cg_prize__good__name {
    font-size: 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    color: #8a60ff;
  }

  .cg_prize__good__image {
    width: 125px;
    display: flex;
    position: relative;
  }

  .cg_prize__good__image img {
    max-width: 100%;
  }

  .cg_prize__good__image .btn {
    top: 5px;
    right: 5px;
    position: absolute;
    padding: 0;
    height: 30px;
    width: 30px;
    background-color: rgba(255, 0, 0, .58) !important;
  }

  .cg_prize__good__image .btn:hover {
    background-color: rgba(255, 0, 0, 1) !important;
  }

  .cg_prize__notify {
    background-color: #FD414C;
    padding: 14px;
    margin: 0 -14px;
    width: calc(100% + 28px);
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 10px;
    line-height: 12px;
    color: #fff;
    font-weight: 400;
  }

  .cg_form-control {
    border-radius: 0 10px 10px 0 !important;
    margin: 0 !important;
    border-left: unset;
  }

  .cg_slogan {
    max-width: 400px;
    width: 100%;
  }
</style>


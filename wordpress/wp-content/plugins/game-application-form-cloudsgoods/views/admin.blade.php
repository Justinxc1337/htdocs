<section class="cg_index">
    <h1 class="cg_title">CloudsGoods</h1>

    <p class="cg_subtitle">Create a game form widget to increase leads by 15x. Give visitors discounts and promo codes
        in game form to make their first purchase faster!</p>

    <div class="cg_information">
        <ul class="cg_information-list">
            <li class="cg_information-item">15 times more effective than ordinary application forms</li>
            <li class="cg_information-item">Visitors spend more time on your site thanks to the game</li>
            <li class="cg_information-item">Gifts in game form stimulate to purchase</li>
            <li class="cg_information-item">The cost of the lead is reduced as people are more likely to click on the
                game form of applications
            </li>
        </ul>
    </div>

    <div class="authorization">
        <div class="switch-container">
            <div class="switch-buttons">
                <button
                        class="switch-button active"
                        onclick="switchAuth('auth')"
                        data-type="auth"
                >
                    Authorization
                </button>

                <button
                        class="switch-button"
                        onclick="switchAuth('register')"
                        data-type="register"
                >
                    Registration
                </button>
            </div>
        </div>

        <div class="cg_login"></div>
    </div>

    <div class="cg_tabs">
        <div class="cg_tab cg_tab_active" data-tab="faq" onclick="switchTabs('faq')">FAQ</div>
        <div class="cg_tab" data-tab="instruction" onclick="switchTabs('instruction')">Instructions</div>
        <div class="cg_tab" data-tab="contact" onclick="switchTabs('contact')">Contact Us</div>
        <div class="cg_tab" data-tab="premium" onclick="switchTabs('premium')">Go to PREMIUM</div>
    </div>

    <div class="cg_load-content">
        <div class="cg_load-content__container"></div>
    </div>

    <div class="cg_index_notify"></div>
</section>

<script type="text/javascript">
  let notifications = [];

  const templateNotify = (data, index) => {
    return `
            <div class="notification ${ data.status }_msg" data-notify="${ index }">${ data.message }</div>
        `;
  };
  const
      templateRegistrationInputs = () => {
        return `
            <div class="cg_login__registration">
                <p>To register, go to <a href="https://cloudsgoods.com/login/registry" target="_blank">cloudsgoods.com</a></p>
                <p>After registering on the site, log in to the plugin with the same username and password</p>
            </div>

            <a href="https://cloudsgoods.com/login/registry" target="_blank" class="btn btn-cg rainbow">Go to the site</a>
        `;
      },
      templateAuthSuccess = (data) => {
        return `
            <div class="cg_login__auth">
                <h3 class="cg_login__auth-title">You are logged in</h3>
                <p><strong>Your login:</strong> ${ data?.email }</p>
                <span>Go to "Profile" to get more information about your account.</span>
                <button class="btn link red cg_login__auth-button" onclick="logout()">LOG OFF</button>
            </div>
        `;
      },
      templateAuthorizationInputs = () => {
        return `
            <form class="cg_auth_form" id="cg_auth_form">
                <div class="auth-inner">
                    <div class="input-form-element">
                        <div class="input-component">
                            <label class="body">
                                <span class="title" data-lang="cg_auth_login_title">E-mail</span>
                                <input name="cg_login" type="email" class="input" id="cg_user_name">
                            </label>
                        </div>

                        <div class="input-component">
                            <label class="body">
                                <span class="title" data-lang="cg_auth_password_title">Password</span>
                                <input name="cg_password" type="password" class="input" id="cg_user_password">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <button class="btn btn-cg rainbow" type="button" onclick="cgAuthUser()">Sign in</button>
                </div>
            </form>

            <div class="col-sm-12 text-center">
                <a href="https://cloudsgoods.com/login/recovery" target="_blank" class="btn link">Forgot password?</a>
            </div>
        `;
      },
      templateFAQ = () => {
        return `
            <div class="cg_faq"></div>
        `;
      },
      templateFAQItem = (data) => {
        return `
            <div class="cg_faq__item" data-item="${ data.id }">
                <p class="cg_faq__item-title">${ data.title }</p>
                <div class="cg_faq__item-content"></div>
            </div>
        `;
      },
      templateAccordion = (data) => {
        return `
            <div class="cg_accordion">
                <div class="cg_accordion__header" onclick="openAccordion(event)">
                    <span class="cg_accordion__chevron">&#5171;</span>
                    <span class="cg_accordion__title">${ data.title }</span>
                </div>

                <div class="cg_accordion__body">
                    <div class="cg_accordion__content">${ data.content }</div>
                </div>
            </div>
        `;
      },
      templateInstruction = () => {
        return `
            <div class="cg_instructions">
                <div class="cg_instruction">
                    <p>Instructions for using and installing plugin are described in detail on the <a class="cg_instruction__link" target="_blank" href="https://cloudsgoods.com/info/wpinstructions">cloudsgoods.com/info/wpinstructions</a></p>
                </div>
            </div>
        `;
      },
      templateContact = () => {
        return `
            <div class="cg_contact">
                <h2>Our contacts</h2>

                <p>
                    <strong>Email:</strong>
                    <a href="mailto:product@cloudsgoods.com" target="_blank">product@cloudsgoods.com</a>
                </p>

                <p>
                    <strong>Instagram:</strong>
                    <a href="http://instagram.com/_u/cloudsgoods_" target="_blank">@cloudsgoods_</a>
                </p>

                <p>
                    <strong>Telegram:</strong>
                    <a href="https://t.me/feedback_cloudsgoods" target="_blank">@feedback_cloudsgoods</a>
                </p>

                <p>
                    <strong>Phone number:</strong>
                    <a href="tel:+79266430078" target="_blank">+79266430078</a>
                </p>
            </div>
        `;
      },
      templatePremium = () => {
        return `
            <div class="cg_premium">
                <p class="cg_premium__subtitle">Upgrade to premium and start collecting more contacts of your visitors!</p>

                <p><strong>You will have access to:</strong></p>

                <ul class="cg_premium__list">
                    <li>More phone numbers</li>
                    <li>More email contacts</li>
                    <li>We will confirm the collected contacts with a code</li>
                </ul>

                <p class="cg_premium__description">Choose the most suitable package in "Prices" and increase number of sending applications up to 15 times!</p>

                <a href="/wp-admin/admin.php?page=cg_menu_adminpagetarif" class="btn purple cg_premium__link">Go to Prices</a>
            </div>
        `;
      };

  const
      _render = (data, selector, template, render = true) => {
        const block = document.querySelector(`.${ selector }`);
        block.innerHTML = '';

        if(render) {
          if(data) {
            data.forEach((item, index) => block.innerHTML += template(item, index));
          } else {
            block.innerHTML = template();
          }
        }
      },
      sendFormData = (method, action, id) => {
        let formInstance = document.getElementById(id);
        const formData = new FormData(formInstance);

        formData.append('action', action);

        const data = {};
        formData.forEach((value, key) => data[key] = value);

        jQuery.ajax({
          type: method,
          url: '/wp-admin/admin-post.php',
          data: data,
          success: function(res) {
            if(JSON.parse(res).error) {
              notify('error', JSON.parse(res).error);
            }
            checkAuth();
          }
        });
      };

  const
      switchAuth = (type) => {
        const buttons = document.querySelectorAll('.switch-button');

        buttons.forEach(item => {
          item.classList.remove('active');
          if(item.dataset.type === type) {
            item.classList.add('active');
          }
        });

        if(type === 'auth') {
          _render(null, 'cg_login', templateAuthorizationInputs);
        } else {
          _render(null, 'cg_login', templateRegistrationInputs);
        }
      },
      switchTabs = (type) => {
        const tabs = document.querySelectorAll('.cg_tab');

        const templates = {
          faq: templateFAQ,
          instruction: templateInstruction,
          contact: templateContact,
          premium: templatePremium,
        };

        tabs.forEach(item => {
          item.classList.remove('cg_tab_active');
          if(item.dataset.tab === type) {
            item.classList.add('cg_tab_active');
            if(type === 'faq') {
              getFAQ();
            } else {
              _render(null, 'cg_load-content__container', templates[type]);
            }
          }
        });
      };

  const openAccordion = (e) => {
    const cg_accordion = e.target.parentElement.parentElement;
    const cg_accordion_body = cg_accordion.querySelector('.cg_accordion__body');
    const cg_accordion__content = cg_accordion.querySelector('.cg_accordion__content');

    if(cg_accordion.classList.contains('cg_accordion_active')) {
      cg_accordion.classList.remove('cg_accordion_active');
      cg_accordion_body.style.cssText = `height: 0;`;
    } else {
      cg_accordion.classList.add('cg_accordion_active');
      cg_accordion_body.style.cssText = `height: ${ cg_accordion__content.offsetHeight }px;`;
    }
  };

  const getFAQ = () => {
    const data = [
      {
        'id': 1,
        'title': 'General Questions',
        'issues': [
          {
            'id': 1,
            'title': 'Why do I need a playful application form?',
            'content': `
                <p>The game application form increases the number of leads, because it attracts the visitor's attention by 70% more due to its interactivity.</p>
                <p>In addition, game mechanics encourage people to send a contact more often because the game drops prizes (discounts, promo codes), which can be obtained by leaving a contact.</p>
            `,
          },
          {
            'id': 2,
            'title': 'How do I log in and access the plugin?',
            'content': `
                <p>Go to <a href="https://cloudsgoods.com" target="_blank">cloudsgoods.com</a> and register.</p>
                <p>Then log in with the same username and password in the plugin on WordPress.</p>
            `,
          },
          {
            'id': 3,
            'title': 'How do I set up a plugin in Elementor?',
            'content': '<p>Go to the instructions section. There we told you about all kinds of game application form placements.</p>',
          },
          {
            'id': 4,
            'title': 'How do I configure the plugin in WP bakery?',
            'content': 'There will be a manual here soon',
          },
          {
            'id': 5,
            'title': 'How to make a game application form on the site?',
            'content': `
                <div>
                    <p>In order to use the game widget with the application form, first create a game mechanics in the "Game Setup" section.</p>
                    <p>If you have a game created, then go to the "Instructions" section, where we answered the questions on how to place the plugin in WP Bakery and Elementor.</p>
                </div>
            `,
          },
          {
            'id': 6,
            'title': 'How do I start setting up the game?',
            'content': `
                <div>
                    <p>The game is set up in a few minutes. Go to "Game Setup" on the left side menu of the plugin.</p>
                    <img src="<?php echo str_replace('/compiled/', '/', plugins_url('/assets/settings/screenshots/4.png', __FILE__)); ?>" alt="">
                    <p>The whole setup is done in a few steps:</p>
                    <ul>
                        <li>Choice of mechanics of the game</li>
                        <li>Choice of game template</li>
                        <li>Template styling</li>
                        <li>Preview and launch</li>
                    </ul>
                </div>
            `,
          },
          {
            'id': 7,
            'title': 'I created a game, how do I install the game in the widget?',
            'content': 'For detailed instructions on installing the game, see the "Instructions" section.',
          },
          {
            'id': 8,
            'title': 'Where else can I post this game?',
            'content': `
                <div>
                    <ul>
                        <li>Marketplaces</li>
                        <li>On a website</li>
                        <li>In stores, restaurants, or on product packaging</li>
                        <li>Social networks</li>
                        <li>On mobile app</li>
                        <li>In commercials</li>
                    </ul>
                    <p>For each game we generate a QR code, a short link, an API for integration into a mobile application as well as a widget for the website.</p>
                    <p>Examples of how to use our games offline with a QR code:</p>
                    <img src="<?php echo str_replace('/compiled/', '/', plugins_url('/assets/settings/screenshots/6.jpg', __FILE__)); ?>" alt="">
                </div>
            `,
          },
          {
            'id': 9,
            'title': 'Where are the collected contacts stored?',
            'content': `
                <div>
                    <p>All collected contacts from the request form are stored in the "Contacts" section.</p>
                    <p>The section displays collected visitor data (phone numbers, email, name, and the date the contact was sent). This section also provides search and sorting of contacts by date.</p>
                    <p>You can unload contacts and add them to the CRM system.</p>
                    <img src="<?php echo str_replace('/compiled/', '/', plugins_url('/assets/settings/screenshots/8.png', __FILE__)); ?>" alt="">
                    <p>The premium version provides notifications when a visitor sends a contact.</p>
                </div>
            `,
          },
          {
            'id': 10,
            'title': 'How do I give the prize to the winner?',
            'content': `
                <div>
                    <p>You can give out a prize in two ways:</p>
                    <ol>
                        <li>In the CloudGoods plugin in WordPress</li>
                        <li>On the cloudsgoods.com service</li>
                    </ol>
                    <p><i>To give away a prize in the CloudGoods plugin:</i></p>
                    <ol>
                        <li>
                            Go to the "Give Out Prizes" section on the side menu
                            <img src="<?php echo str_replace('/compiled/', '/', plugins_url('/assets/settings/screenshots/9.png', __FILE__)); ?>" alt="">
                        </li>
                        <li>
                            You will see a table with the following data:
                            <ul>
                                <li>Contact of the user who won the prize</li>
                                <li>Prize name and amount or percentage</li>
                                <li>Coupon number</li>
                                <li>How many days is the prize valid</li>
                            </ul>
                        </li>
                        <li>
                            If a winner has contacted you and provided a coupon, you can search for their gift to see the name of the prize and the amount, and if the prize has been given out previously:
                            <img src="<?php echo str_replace('/compiled/', '/', plugins_url('/assets/settings/screenshots/10.png', __FILE__)); ?>" alt="">
                            If the prize has not been given to the player before and its validity period has not expired, then the prize will have a bright “Give Out” button:
                            Clicking on the giveaway button will open a pop-up to confirm the prize giveaway:
                            Once you've confirmed the prize, the status will change to given out.
                        </li>
                    </ol>

                    <p>Don't forget to email winners who didn't receive a prize that they have a gift to spend in your store. To do this, apply sorting to “unissued prizes” and copy the contacts to the mailing service.</p>
                    <p><i>How to give away a prize at CloudsGoods.com:</i></p>
                    <ol>
                        <li>Log in to cloudsgoods.com with the same username and password you use in the WordPress plugin </li>
                        <li>Go to the "Prize Giveaway" section in the top footer</li>
                        <li>
                            A table will open up in front of you with the following data:
                            <ul>
                                <li>Contact of the user who won the prize</li>
                                <li>Prize name and amount or percentage</li>
                                <li>Coupon number</li>
                                <li>
                                    How many days is the prize valid?
                                    <img src="<?php echo str_replace('/compiled/', '/', plugins_url('/assets/settings/screenshots/11.png', __FILE__)); ?>" alt="">
                                </li>
                            </ul>
                        </li>
                        <li>If a winner has contacted you and provided a coupon, you can search for their gift to see the name of the prize and amount, as well as whether the prize has been given out previously</li>
                        <li>If the prize hasn't been given out before and it's not expired, there will be a bright "Give Out" button next to the prize:</li>
                        <li>Clicking on the "Give away" button will open a pop-up to confirm the prize:</li>
                        <li>After you confirm the prize issuance, the status will change to Issued.</li>
                    </ol>
                    <p>Don't forget to send a mailing to winners who didn't receive a prize, telling them that they have a gift to spend in your store. To do this, apply sorting to "not given out" and copy the contacts into the newsletter service.</p>
                </div>
            `,
          },
          {
            'id': 11,
            'title': 'Who is this widget for?',
            'content': '<p>Game application forms are suitable for all fields of activity. It\'s also suitable for the B2C segment and works well in B2B</p>',
          },
          {
            'id': 12,
            'title': 'Why do I need to provide information about the company?',
            'content': '<p>We automatically generate documents for every game we create. In order for the document to be correctly generated, the following information about the company is required: ID, company name, company address. If you are self-employed, then select "personal use". If you have an individual entrepreneur, LLC, then select “for business”.</p>',
          },
          {
            'id': 13,
            'title': 'How many contacts are available in free mode?',
            'content': `
                <p>You can use our service for free. You have 5 email contacts per day available. That is, your application form will collect only email and only 5pcs/day.</p>
                <p>Phone numbers are not available in free mode.</p>
            `,
          },
          {
            'id': 14,
            'title': 'How do I buy contact packages?',
            'content': `
                <div>
                    <p>Go to "Prices" and select the package that suits you best. Then you'll get to cloudsgoods.com, where you'll need to log in to buy a package</p>
                    <img src="<?php echo str_replace('/compiled/', '/', plugins_url('/assets/settings/screenshots/12.png', __FILE__)); ?>" alt="">
                </div>
            `,
          },
          {
            'id': 15,
            'title': 'I bought a package of contacts. Where can I see my balances?',
            'content': `
                <div>
                    <p>The "Prices" section shows your package balances</p>
                    <img src="<?php echo str_replace('/compiled/', '/', plugins_url('/assets/settings/screenshots/13.png', __FILE__)); ?>" alt="">
                </div>
            `,
          },
        ]
      },
    ];

    _render(null, 'cg_load-content__container', templateFAQ);

    data.forEach(item => {
      const itemData = [{ id: item.id, title: item.title }];
      const itemDocument = document.querySelector('.cg_faq');
      itemData.forEach((item, index) => itemDocument.innerHTML += templateFAQItem(item, index));

      const itemIssues = item.issues;
      const itemIssuesDocument = document.querySelector(`[data-item="${ item.id }"] .cg_faq__item-content`);

      itemIssues.forEach((issue, index) => {
        // var decoder = decoder || document.createElement('div');
        // decoder.innerHTML = issue.text;
        //
        // const data = {
        //   ...issue,
        //   text: decoder.textContent
        // };

        itemIssuesDocument.innerHTML += templateAccordion(issue, index);
      });
    });
  };

  const
      checkAuth = () => {
        const data = {
          action: 'cgsrv_validate_token'
        };

        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: data,
          success: function(res) {
            const response = JSON.parse(res);

            if(response?.error) {
              document.querySelector('.switch-container').style.cssText = 'display: flex;';
              _render(null, 'cg_login', templateAuthorizationInputs);
            } else {
              document.querySelector('.switch-container').style.cssText = 'display: none;';
              _render([response.data], 'cg_login', templateAuthSuccess);
            }
          }
        });
      },
      logout = () => {
        const data = {
          action: 'cgsrv_logout'
        };

        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: data,
          success: function() {
            document.querySelector('.switch-container').style.cssText = 'display: flex;';
            _render(null, 'cg_login', templateAuthorizationInputs);
          }
        });
      },
      cgAuthUser = () => {
        sendFormData('POST', 'cgsrv_get_token', 'cg_auth_form');
      };

  const notify = (status, message) => {
    notifications.push({ status, message });

    _render(notifications, 'cg_index_notify', templateNotify);

    setTimeout(() => {
      const notify = document.querySelector('.cg_index_notify');
      notify.innerHTML = '';
      notifications = [];
    }, 3000);
  };

  window.onload = () => {
    getFAQ();
    checkAuth();
  };
</script>

<style>
  @include('../assets/app.css')

  .cg_index {
    padding-right: 20px;
  }

  .cg_index_notify {
    position: fixed;
    top: 40px;
    right: 5px;
  }

  .cg_subtitle {
    max-width: 500px;
    font-size: 20px;
    line-height: 25px;
  }

  .cg_lang {
    margin-top: 40px;
  }

  .cg_lang-form__title {
    display: inline-block;
    font-size: 20px;
    margin-bottom: 10px;
  }

  select.cg_lang-form__select {
    max-width: 200px;
  }

  .cg_information {
    max-width: 550px;
    margin-top: 40px;
  }

  .cg_information-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding-left: 20px;
  }

  .cg_information-item {
    padding-left: 5px;
    font-size: 20px;
    line-height: 25px;
    list-style: '✓';
  }

  .cg_information-item::marker {
    color: #000;
    font-size: 20px;
  }

  .cg_auth_form {
    max-width: 500px;
  }

  .cg_tabs {
    margin-top: 40px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 20px;
  }

  .cg_tab {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 40px;
    padding: 7px;
    font-size: 20px;
    background-color: #D9D9D9;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color .25s linear;
  }

  .cg_tab:hover {
    background-color: rgba(138, 96, 255, 0.3);
  }

  .cg_tab.cg_tab_active {
    background-color: rgba(138, 96, 255, 0.4);
  }

  .switch-container {
    display: none;
    justify-content: center;
    padding: 18px 0;
    position: relative;
  }

  .switch-container .switch-buttons {
    background-color: #f7f7f7;
    border-radius: 100px;
    display: flex;
  }

  .switch-container .switch-buttons .switch-button {
    background-color: #f7f7f7;
    border-radius: 100px;
    font-weight: 500;
    letter-spacing: -.5px;
    padding: 20px 30px;
    height: unset;
    color: #c4c4c4;
    border: none;
    outline: none;
    cursor: pointer;
    transition: all .25s linear;
  }

  .switch-container .switch-buttons .switch-button.active {
    background-color: #8a60ff;
    color: #fff;
  }

  .authorization {
    max-width: 600px;
  }

  .cg_login {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .cg_login__registration {
    text-align: center;
  }

  .cg_login__registration p {
    margin: 0 0 10px 0;
  }

  .cg_login > a {
    text-decoration: none;
  }

  .cg_login > a:hover {
    color: #fff;
  }

  .cg_auth_form {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .auth-inner {
    width: 100%;
  }

  .cg_login__auth {
    width: 100%;
    max-width: 330px;
    display: flex;
    flex-direction: column;
    padding: 20px;
    margin: 0 auto 0 0;
  }

  .cg_login__auth-title {
    margin: 0;
    font-size: 30px;
    line-height: 35px;
    color: #8a60ff;
  }

  .cg_login__auth p {
    font-size: 16px;
  }

  .btn.link.cg_login__auth-button {
    margin: 20px auto 0 0;
    padding: 5px 0;
    font-size: 20px;
    text-transform: uppercase;
  }

  .cg_load-content__container {
    display: flex;
    padding: 40px;
  }

  .cg_load-content__container h2 {
    font-size: 30px;
    line-height: 30px;
    margin: 0 0 20px 0;
  }

  .cg_load-content__container p {
    margin: 5px 0 0 0;
    font-size: 20px;
    line-height: 24px;
  }

  .cg_load-content__container a {
    text-decoration-color: transparent;
    color: inherit;
    transition: all .25s linear;
  }

  .cg_load-content__container a:hover {
    text-decoration-color: inherit;
  }

  .cg_load-content__container p.cg_premium__subtitle {
    margin-bottom: 20px;
  }

  .cg_premium__list {
    margin-top: 20px;
    font-size: 20px;
    line-height: 24px;
  }

  .cg_load-content__container p.cg_premium__description {
    margin-top: 30px;
    max-width: 570px;
  }

  .cg_premium__link {
    margin-top: 20px;
    text-decoration: none;
    display: inline-flex;
  }

  .cg_faq {
    grid-gap: 30px;
    display: grid;
    grid-template-columns: 1fr;
  }

  .cg_faq__item {
    display: flex;
    flex-direction: column;
  }

  .cg_faq__item-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .cg_faq__item-content {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 30px;
  }

  .cg_accordion__header {
    align-items: center;
    cursor: pointer;
    display: flex;
    font-size: 16px;
    gap: 8px;
    padding: 8px 0;
  }

  .cg_accordion__chevron {
    transform: rotate(0);
    transition: transform .25s linear;
    font-size: 10px;
  }

  .cg_accordion.cg_accordion_active .cg_accordion__chevron {
    transform: rotate(90deg);
  }

  .cg_accordion__body {
    height: 0;
    overflow: hidden;
    transition: height .25s linear;
  }

  .cg_accordion__content {
    padding: 8px 16px 16px 20px;
  }

  .cg_accordion__content img {
    max-width: 100%;
  }

  .cg_accordion__content ul {
    list-style: disc;
    margin-left: 2em;
  }

  .cg_accordion__content p {
    font-size: 14px;
    line-height: 24px;
  }

  .cg_instructions {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .cg_instruction {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .cg_instruction a.cg_instruction__link {
    color: #8a60ff;
    text-decoration: underline;
    transition: all .25s linear;
  }

  .cg_instruction a.cg_instruction__link:hover {
    text-decoration-color: transparent;
  }
</style>

{{--    <div class="cg_lang">--}}
{{--        <form class="cg_lang-form">--}}
{{--            <label>--}}
{{--                <span class="cg_lang-form__title">SPECIFY YOUR LANGUAGE, WIDGET SETTING DEPENDS ON THIS:</span>--}}
{{--                <select name="lang" class="cg_lang-form__select">--}}
{{--                    <option value="ru">Русский</option>--}}
{{--                    <option value="eng">English</option>--}}
{{--                </select>--}}
{{--            </label>--}}
{{--        </form>--}}
{{--    </div>--}}

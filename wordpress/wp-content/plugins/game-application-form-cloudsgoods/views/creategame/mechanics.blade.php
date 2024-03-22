<div class="cg_mechanics"></div>

<script>
  var mechanics_list = [
    {
      image: '<?php echo str_replace('/compiled/', '/', plugins_url('/assets/images/mech_1.png', __FILE__)); ?>',
      title: 'Fast Growth.',
      text: 'The winner is the one who scores the most game points. There is a tournament table and referral program in this mechanic.',
      type: 'viral'
    },
    {
      image: '<?php echo str_replace('/compiled/', '/', plugins_url('/assets/images/mech_2.png', __FILE__)); ?>',
      title: 'Audience Entertainment.',
      text: 'Only those users who play under the lucky number win prizes. You set up the lucky numbers yourself. Players have several attempts per day.',
      type: 'ordinal'
    },
    {
      image: '<?php echo str_replace('/compiled/', '/', plugins_url('/assets/images/mech_3.png', __FILE__)); ?>',
      title: 'Customer returns',
      text: 'Prizes are won immediately by all users, you set only the number of prizes and when all the prizes are given away, the game will end.',
      type: 'fast'
    }
  ];

  var templateMechanic = (data) => {
    return `
        <div
                class="cg_mechanic"
                onclick="nextStep({name: 'mechanics', type: '${ data.type }'})"
        >
            <div class="cg_mechanic__image">
                <img
                        src="${ data.image }"
                        alt="${ data.title }"
                        class="cg_mechanic__image_img"
                >
            </div>

            <h3 class="cg_mechanic__title">${ data.title }</h3>
            <p class="cg_mechanic__text">${ data.text }</p>
        </div>
    `;
  };

  _render(mechanics_list, 'cg_mechanics', templateMechanic);
</script>

<style>
  @include('../assets/app.css')

  .cg_mechanics {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 150px;
  }

  .cg_mechanic {
    background: linear-gradient(162.65deg, #ae6fff 9.67%, #8a60ff 29.52%, #4328eb 103.9%);
    border-radius: 10px;
    box-shadow: 0 17px 21px rgba(0, 0, 0, .11);
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    min-height: 400px;
    padding: 30px 25px;
    position: relative;
    transform: scale(1);
    transition: transform .25s linear;
    width: calc((100% - 40px) / 3);
    min-width: 320px;
    box-sizing: border-box;
  }

  .cg_mechanic:hover {
    transform: scale(1.03);
  }

  .cg_mechanic__image {
    left: 0;
    margin-bottom: 30px;
    position: absolute;
    top: -100px;
    width: 100%;
  }

  .cg_mechanic__image:before {
    content: "";
    display: block;
    padding-top: 320px;
  }

  .cg_mechanic__image_img {
    left: 50%;
    position: absolute;
    top: 0;
    transform: translate(-50%);
  }

  .cg_mechanic__title {
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    line-height: 24px;
    text-align: center;
  }

  .cg_mechanic__text {
    color: #fff;
    font-size: 14px;
    line-height: 17px;
    min-height: 70px;
    margin-top: 18px;
  }
</style>

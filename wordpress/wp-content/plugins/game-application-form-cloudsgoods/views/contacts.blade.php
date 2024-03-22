<section class="cg_contacts">
    <h1 class="cg_contacts__title" data-lang="cg_contacts_title">MY CONTACTS</h1>

    <div class="cg_contacts__sort">
        <span data-lang="cg_contacts_sort_date">Sort by date:</span>
        <label>
            <input name="cg-from-date" type="date" onchange="sortDateFrom(event)" data-placeholder="DD.MM.YY">
        </label>
        -
        <label>
            <input name="cg-to-date" type="date" onchange="sortDateTo(event)" data-placeholder="DD.MM.YY">
        </label>
    </div>

    <div class="cg_contacts__actions">
        <div class="cg_contacts__search">
            <label>
                <input type='text' placeholder="Search" onchange="getSearch(event)">
            </label>
        </div>

        <div class="cg_contacts__download">
            <button
                    class="btn"
                    type='button'
                    onclick='cgDownloadContacts()'
                    data-lang="cg_contacts_download_button"
            >
                Upload contacts
            </button>
        </div>
    </div>

    <div class="scrollbar">
        <div class="table list">
            <div class="th">
                <div class="td" data-lang="cg_contacts_table_email">E-Mail</div>
                <div class="td" data-lang="cg_contacts_table_phone">Phone number</div>
                <div class="td" data-lang="cg_contacts_table_name">Name</div>
                <div class="td" data-lang="cg_contacts_table_name">Date</div>
            </div>
            <div class="rows_group"></div>
        </div>
    </div>

    @include('../assets/include/pagination.blade.php')
</section>

<script>
  const action = 'cgsrv_contact_list';
  const loadingBlock = 'rows_group';
  const options = { cg_filter: '', cg_from_date: '', cg_to_date: '' };

  const
      template = (data) => {
        return `
            <div class="tr">
                <div class="td">${ data.email ? data.email : '-' }</div>
                <div class="td">${ data.phone ? data.phone : '-' }</div>
                <div class="td">${ data.name ? data.name : '-' }</div>
                <div class="td">${ data.time ? new Date(data.time * 1000).toLocaleDateString('ru-RU') : '-' }</div>
            </div>
        `;
      };

  const
      cgDownloadContacts = () => {
        const formData = new FormData();
        formData.append('action', 'cgsrv_download_contacts');
        if(options.cg_from_date) {
          formData.append('cg_from_date', options.cg_from_date);
        }

        if(options.cg_to_date) {
          formData.append('cg_to_date', options.cg_to_date);
        }

        if(options.cg_filter) {
          formData.append('cg_filter', options.cg_filter);
        }

        const data = {};
        formData.forEach((value, key) => data[key] = value);

        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: data,
          success: function(res) {
            const url = window.URL.createObjectURL(new Blob([res]));
            const link = document.createElement('a');

            link.href = url;
            link.setAttribute('download', 'contacts.csv');
            document.body.appendChild(link);
            link.click();
            link.remove();
          }
        });
      },
      getSearch = (cg_filter) => {
        options.cg_filter = cg_filter.target.value;

        getData(action, 1, 20, options);
      },
      sortDateFrom = (cg_filter) => {
        options.cg_from_date = new Date(cg_filter.target.value) / 1000;

        getData(action, 1, 20, options);
      },
      sortDateTo = (cg_filter) => {
        options.cg_to_date = new Date(cg_filter.target.value) / 1000;

        getData(action, 1, 20, options);
      };
</script>

<style>
  @include('../assets/app.css')
  .cg_contacts {
    padding-right: 20px;
  }

  @media (max-width: 782px) {
    .cg_contacts {
      padding-right: 10px;
    }
  }

  .cg_contacts__title {
    font-size: 40px;
    line-height: 1;
    font-weight: bold;
    color: #8a60ff;
    text-transform: uppercase;
  }

  .cg_contacts__sort {
    width: 100%;
    max-width: 500px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: #000;
  }

  .cg_contacts__sort span {
    margin-right: auto;
  }

  .cg_contacts__sort label {
    max-width: 160px;
  }

  .cg_contacts__actions {
    width: 100%;
    max-width: 500px;
    margin-top: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .cg_contacts__search {
    width: 100%;
  }
</style>

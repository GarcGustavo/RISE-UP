<template>
  <!-- skip previous label disable if page < 5 -->
  <ul v-if="pager.pages && pager.pages.length" class="pagination" :style="ulStyles">
    <li class="page-item skip-prev" :class="{'disabled': pager.currentPage < 5}" :style="liStyles">
      <!-- if pressed set page to current - 5 -->
      <a
        class="page-link"
        @click="setPage(pager.currentPage - 5)"
        :style="aStyles"
      >{{labels.skip_prev}}</a>
    </li>
    <!-- skip to first page label -->
    <li class="page-item first" :class="{'disabled': pager.currentPage === 1}" :style="liStyles">
      <a class="page-link" @click="setPage(1)" :style="aStyles">{{labels.first}}</a>
    </li>
    <!-- previous label -->
    <li class="page-item previous" :class="{'disabled': pager.currentPage === 1}" :style="liStyles">
      <a
        class="page-link"
        @click="setPage(pager.currentPage - 1)"
        :style="aStyles"
      >{{labels.previous}}</a>
    </li>
    <!-- list of pages -->
    <li
      v-for="page in pager.pages"
      :key="page"
      class="page-item page-number"
      :class="{'active': pager.currentPage === page}"
      :style="liStyles"
    >
      <!-- make them clickable -->
      <a class="page-link" @click="setPage(page)" :style="aStyles">{{page}}</a>
    </li>
    <!-- next label -->
    <li
      class="page-item next"
      :class="{'disabled': pager.currentPage === pager.totalPages}"
      :style="liStyles"
    >
      <a class="page-link" @click="setPage(pager.currentPage + 1)" :style="aStyles">{{labels.next}}</a>
    </li>
    <!-- skip to last page label -->
    <li
      class="page-item last"
      :class="{'disabled': pager.currentPage === pager.totalPages}"
      :style="liStyles"
    >
      <a class="page-link" @click="setPage(pager.totalPages)" :style="aStyles">{{labels.last}}</a>
    </li>
    <!-- skip next 5 label set page to current + 5 -->
    <li
      class="page-item skip-next"
      :class="{'disabled': pager.currentPage > pager.totalPages - 5}"
      :style="liStyles"
    >
      <a
        class="page-link"
        @click="setPage(pager.currentPage + 5)"
        :style="aStyles"
      >{{labels.skip_next}}</a>
    </li>
  </ul>
</template>

<script>
import paginate from "jw-paginate";

const defaultLabels = {
  first: "First",
  last: "Last",
  previous: "<",
  next: ">",
  skip_prev: "<<",
  skip_next: ">>"
};

const defaultStyles = {
  ul: {
    margin: 0,
    padding: 0,
    display: "inline-block"
  },
  li: {
    listStyle: "none",
    display: "inline",
    textAlign: "center"
  },
  a: {
    border: 0,
    cursor: "pointer",
    padding: "6px 12px",
    display: "block",
    float: "left"
  }
};

export default {
  props: {
    items: {
      type: Array,
      required: true
    },
    initialPage: {
      type: Number,
      default: 1
    },
    pageSize: {
      type: Number,
      default: 10
    },
    maxPages: {
      type: Number,
      default: 5
    },
    labels: {
      type: Object,
      default: () => defaultLabels
    },
    styles: {
      type: Object
    },
    disableDefaultStyles: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      pager: {},
      ulStyles: {},
      liStyles: {},
      aStyles: {}
    };
  },
  created() {
    if (!this.$listeners.changePage) {
      throw 'Missing required event listener: "changePage"';
    }

    // set default styles unless disabled
    if (!this.disableDefaultStyles) {
      this.ulStyles = defaultStyles.ul;
      this.liStyles = defaultStyles.li;
      this.aStyles = defaultStyles.a;
    }

    // merge custom styles with default styles
    if (this.styles) {
      this.ulStyles = { ...this.ulStyles, ...this.styles.ul };
      this.liStyles = { ...this.liStyles, ...this.styles.li };
      this.aStyles = { ...this.aStyles, ...this.styles.a };
    }

    // set page if items array isn't empty
    if (this.items && this.items.length) {
      this.setPage(this.initialPage);
    }
  },
  methods: {
    setPage(page) {
      const { items, pageSize, maxPages } = this;

      // get new pager object for specified page
      const pager = paginate(items.length, page, pageSize, maxPages);

      // get new page of items from items array
      const pageOfItems = items.slice(pager.startIndex, pager.endIndex + 1);

      // update pager
      this.pager = pager;

      // emit change page event to parent component
      this.$emit("changePage", pageOfItems);
    }
  }
};
</script>

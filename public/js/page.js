
const pagination = document.querySelector('.pagination');

const pagesnext = document.createElement("div");
pagesnext.classList.add("pages");
pagination.append(pagesnext);

const nextPaginations = nextPages.map(function(page) {
    const pages = document.createElement("div");
    pages.classList.add("page");
    const pageInPages = document.createElement("a");
    pageInPages.href = url + "/?page=" + page;
    pageInPages.innerHTML = page;
    pages.append(pageInPages);

    return pages;
  });

  pagesnext.append(...nextPaginations);

if(next != 0){ 
  const pagelast = document.createElement("div");
  pagelast.classList.add("page");
  pagelast.classList.add("page-control");
  const pageInPagelast = document.createElement("a");
  pageInPagelast.href = url + "/?page=" + lastPage;
  pageInPagelast.innerHTML = '<iconify-icon icon="bxs:right-arrow"></iconify-icon>' + '<iconify-icon icon="bxs:right-arrow"></iconify-icon>';
  pagelast.append(pageInPagelast);
  pagesnext.append(pagelast);
}


const pagecurrent = document.createElement("div");
pagecurrent.classList.add("pages");
pagination.append(pagecurrent);

if(currentPage - 1 != 0){
    const pageprevius = document.createElement("div");
    pageprevius.classList.add("page");
    pageprevius.classList.add("page-control");
    const pageInPageprevius = document.createElement("a");
    pageInPageprevius.href = url + "/?page=" + (currentPage - 1);
    pageInPageprevius.innerHTML = '<iconify-icon icon="bxs:left-arrow"></iconify-icon>';
    pagecurrent.append(pageprevius);
    pageprevius.append(pageInPageprevius);
}

const pages = document.createElement("div");
pages.classList.add("page");
pages.classList.add("active");
const pageInPages = document.createElement("a");
pageInPages.href = url + "/?page=" + currentPage;
pageInPages.innerHTML = currentPage;
pagecurrent.append(pages);
pages.append(pageInPages);

if(currentPage != lastPage){

    const pagenext = document.createElement("div");
    pagenext.classList.add("page");
    pagenext.classList.add("page-control");
    const pageInPagenext = document.createElement("a");
    pageInPagenext.href = url + "/?page=" + (parseInt(currentPage) + 1);
    pageInPagenext.innerHTML = '<iconify-icon icon="bxs:right-arrow"></iconify-icon>';
    pagecurrent.append(pagenext);
    pagenext.append(pageInPagenext);

}


const pagesprevius = document.createElement("div");
pagesprevius.classList.add("pages");
pagination.append(pagesprevius);

const previusPaginations = previusPages.reverse().map(function(page) {
    const pages = document.createElement("div");
    pages.classList.add("page");
    const pageInPages = document.createElement("a");
    pageInPages.href = url + "/?page=" + page;
    pageInPages.innerHTML = page;
    pages.append(pageInPages);

    return pages;
  });

  if(currentPage != 1){
    const pagefirst = document.createElement("div");
    pagefirst.classList.add("page");
    pagefirst.classList.add("page-control");
    const pageInPagefirst = document.createElement("a");
    pageInPagefirst.href = url + "/?page=" + 1;
    pageInPagefirst.innerHTML = '<iconify-icon icon="bxs:left-arrow"></iconify-icon>' + '<iconify-icon icon="bxs:left-arrow"></iconify-icon>';
    pagefirst.append(pageInPagefirst);
    pagesprevius.append(pagefirst);
}

  pagesprevius.append(...previusPaginations);


  


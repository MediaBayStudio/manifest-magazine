document.addEventListener("DOMContentLoaded",function(){function e(t,e){e&&e.classList.remove("loading"),errorPopup.openPopup()}var o,n,p,r,a;o="article.article:last-of-type",n=q(o),p=q(".ftr"),r=!0,a=siteUrl+"/wp-admin/admin-ajax.php",n&&window.addEventListener("scroll",function(){var t;r&&pageYOffset>=p.offsetTop-2*p.offsetHeight&&(r=!1,t=qa("article.article",n.parentElement,!0).map(function(t){return t.getAttribute("data-post-id")}).join(" "),t=["action=create_article","next_article=1","exists_post="+q(o).getAttribute("data-post-id"),"exclude_posts="+t,"parent_category="+n.getAttribute("data-parent-category")].join("&"),fetch(a,{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:t}).then(function(t){return t.ok?t.text():(e((t.status,t.statusText),btn),"")}).then(function(t){try{p.insertAdjacentHTML("beforebegin",t),r=!0}catch(t){e()}}).catch(function(t){e()}))}),errorPopup=new Popup(".error-popup",{closeButtons:".error-popup__close"}),thanksPopup=new Popup(".thanks-popup",{closeButtons:".thanks-popup__close"}),searchPopup=new Popup(".search-popup",{openButtons:".hdr__search",closeButtons:".search-popup__close"})});
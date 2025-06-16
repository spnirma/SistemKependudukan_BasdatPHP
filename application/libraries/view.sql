create or replace view view_comment as
select a.id_produk, count(b.id_comment) as count_comment
from tbl_produk a
left join tbl_comment b on a.id_produk=b.id_produk
group by a.id_produk

create or replace view view_love as
select a.id_produk, count(b.id_user) as count_love
from tbl_produk a
left join tbl_love b on a.id_produk=b.id_produk
group by a.id_produk

ALTER TABLE tbl_produk
ADD pick int(1) not null default 0
SCHEMA "Mst"

create table "Mst".produk (
	produk_id uuid not null default uuid_generate_v4(),
	nama varchar(100) not null,
	brand varchar(40) not null,
	harga int4 not null,
	slug varchar(100) null,
	tgl_dibuat timestamp null default now(),
	tgl_diubah timestamp null,
	tgl_release timestamp null,
	tgl_dihapus timestamp null,
    constraint produk_pk primary key (produk_id)
)

create table "Mst".produk_stok(
    produk_id uuid not null default uuid_generate_v4(),
    stok int4 null default 0,
    tgl_diubah timestamp null default now(),
    constraint produk_stok_pk primary key (produk_id),
    constraint produk_stok_fk foreign key (produk_id) references "Mst".produk(produk_id)
)


SCHEMA "Usr"

create table "Usr"."user" (
    user_id uuid not null default uuid_generate_v4(),
    nama_depan varchar(30) not null,
    nama_belakang varchar(30) not null,
    alamat varchar(200) null,
    nomor_hp varchar(15) null,
    jk bpchar(1) not null,
    tgl_lahir date null,
    constraint user_pk primary key (user_id)
)


SCHEMA "Trx"

create table "Trx".pesanan (
    pesanan_id uuid not null default uuid_generate_v4(),
    user_id uuid not null,
    tgl_pesanan timestamp null default now(),
    kode_voucher varchar(20) null,
    tgl_pembayaran_lunas timestamp null,
    tgl_dibatalkan timestamp null,
    no_pesanan varchar(10) null,
    constraint pesanan_pk primary key (pesanan_id),
    constraint pesanan_fk foreign key (user_id) references "Usr"."user"(user_id)
)

create table "Trx".pesanan_produk (
    pesanan_produk_id uuid not null default uuid_generate_v4(),
    pesanan_id uuid not null,
    produk_id uuid not null,
    jumlah int4 not null default 1,
    tgl_dibuat timestamp null default now(),
    tgl_diubah timestamp null,
    tgl_dihapus timestamp null,
    constraint pesanan_produk_pk primary key (pesanan_produk_id),
    constraint pesanan_produk_fk foreign key (pesanan_id) references "Trx".pesanan(pesanan_id),
    constraint pesanan_produk_fk_1 foreign key (produk_id) references "Mst".produk(produk_id)
)

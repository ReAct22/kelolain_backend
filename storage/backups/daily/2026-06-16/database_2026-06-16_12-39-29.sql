--
-- PostgreSQL database dump
--

\restrict O6kAER2wGmvJArIgmaVNEgvmVtqAf5naM9PzrAgFs2BKCV3yUWpfP50jNbxVg4Z

-- Dumped from database version 18.4
-- Dumped by pg_dump version 18.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration bigint NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration bigint NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    nama_category character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO postgres;

--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection character varying(255) NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: faq; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.faq (
    id bigint NOT NULL,
    kategori_bantuan_id bigint,
    pertanyaan character varying(255) NOT NULL,
    jawaban text NOT NULL,
    is_aktif boolean DEFAULT true NOT NULL,
    urutan integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.faq OWNER TO postgres;

--
-- Name: faq_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.faq_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.faq_id_seq OWNER TO postgres;

--
-- Name: faq_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.faq_id_seq OWNED BY public.faq.id;


--
-- Name: features; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.features (
    id bigint NOT NULL,
    judul character varying(255) NOT NULL,
    deskripsi text,
    ikon character varying(255),
    is_aktif boolean DEFAULT true NOT NULL,
    urutan integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.features OWNER TO postgres;

--
-- Name: features_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.features_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.features_id_seq OWNER TO postgres;

--
-- Name: features_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.features_id_seq OWNED BY public.features.id;


--
-- Name: hero_sections; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hero_sections (
    id bigint NOT NULL,
    judul character varying(255) NOT NULL,
    subjudul text,
    gambar character varying(255),
    tombol_teks character varying(255),
    tombol_url character varying(255),
    is_aktif boolean DEFAULT true NOT NULL,
    urutan integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.hero_sections OWNER TO postgres;

--
-- Name: hero_sections_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.hero_sections_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.hero_sections_id_seq OWNER TO postgres;

--
-- Name: hero_sections_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.hero_sections_id_seq OWNED BY public.hero_sections.id;


--
-- Name: invoice_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.invoice_details (
    id bigint NOT NULL,
    invoice_id bigint NOT NULL,
    produk_id bigint NOT NULL,
    nama_produk character varying(255) NOT NULL,
    harga bigint NOT NULL,
    qty integer NOT NULL,
    subtotal bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.invoice_details OWNER TO postgres;

--
-- Name: invoice_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.invoice_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.invoice_details_id_seq OWNER TO postgres;

--
-- Name: invoice_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.invoice_details_id_seq OWNED BY public.invoice_details.id;


--
-- Name: invoices; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.invoices (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    no_invoice character varying(255) NOT NULL,
    nama_pelanggan character varying(255) NOT NULL,
    no_hp_pelanggan character varying(255),
    total_harga bigint NOT NULL,
    total_bayar bigint NOT NULL,
    kembalian bigint DEFAULT '0'::bigint NOT NULL,
    status character varying(255) DEFAULT 'lunas'::character varying NOT NULL,
    metode_bayar character varying(255) DEFAULT 'cash'::character varying NOT NULL,
    catatan text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT invoices_metode_bayar_check CHECK (((metode_bayar)::text = ANY ((ARRAY['cash'::character varying, 'transfer'::character varying, 'qris'::character varying])::text[]))),
    CONSTRAINT invoices_status_check CHECK (((status)::text = ANY ((ARRAY['lunas'::character varying, 'belum_lunas'::character varying])::text[])))
);


ALTER TABLE public.invoices OWNER TO postgres;

--
-- Name: invoices_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.invoices_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.invoices_id_seq OWNER TO postgres;

--
-- Name: invoices_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.invoices_id_seq OWNED BY public.invoices.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: kata_terlarang; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kata_terlarang (
    id bigint NOT NULL,
    kata character varying(255) NOT NULL,
    jenis character varying(255) DEFAULT 'keduanya'::character varying NOT NULL,
    keterangan text,
    is_aktif boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT kata_terlarang_jenis_check CHECK (((jenis)::text = ANY ((ARRAY['nama_produk'::character varying, 'kategori'::character varying, 'keduanya'::character varying])::text[])))
);


ALTER TABLE public.kata_terlarang OWNER TO postgres;

--
-- Name: kata_terlarang_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kata_terlarang_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.kata_terlarang_id_seq OWNER TO postgres;

--
-- Name: kata_terlarang_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.kata_terlarang_id_seq OWNED BY public.kata_terlarang.id;


--
-- Name: kategori_bantuan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kategori_bantuan (
    id bigint NOT NULL,
    nama character varying(255) NOT NULL,
    ikon character varying(255),
    deskripsi text,
    is_aktif boolean DEFAULT true NOT NULL,
    urutan integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.kategori_bantuan OWNER TO postgres;

--
-- Name: kategori_bantuan_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kategori_bantuan_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.kategori_bantuan_id_seq OWNER TO postgres;

--
-- Name: kategori_bantuan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.kategori_bantuan_id_seq OWNED BY public.kategori_bantuan.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: page_seo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.page_seo (
    id bigint NOT NULL,
    page_key character varying(255) NOT NULL,
    meta_title character varying(255),
    meta_description text,
    meta_keywords character varying(255),
    slug character varying(255),
    og_image character varying(255),
    is_aktif boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.page_seo OWNER TO postgres;

--
-- Name: page_seo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.page_seo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.page_seo_id_seq OWNER TO postgres;

--
-- Name: page_seo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.page_seo_id_seq OWNED BY public.page_seo.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name text NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: product_violations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_violations (
    id bigint NOT NULL,
    produk_id bigint NOT NULL,
    user_id bigint NOT NULL,
    jenis_pelanggaran character varying(255) NOT NULL,
    keterangan text,
    peringatan_ke integer NOT NULL,
    dikirim_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT product_violations_jenis_pelanggaran_check CHECK (((jenis_pelanggaran)::text = ANY ((ARRAY['harga_nol'::character varying, 'nama_tidak_sesuai'::character varying, 'kategori_terlarang'::character varying])::text[])))
);


ALTER TABLE public.product_violations OWNER TO postgres;

--
-- Name: product_violations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_violations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.product_violations_id_seq OWNER TO postgres;

--
-- Name: product_violations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.product_violations_id_seq OWNED BY public.product_violations.id;


--
-- Name: produk_seo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.produk_seo (
    id bigint NOT NULL,
    produk_id bigint NOT NULL,
    meta_title character varying(255),
    meta_description text,
    meta_keywords character varying(255),
    slug character varying(255) NOT NULL,
    og_image character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.produk_seo OWNER TO postgres;

--
-- Name: produk_seo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.produk_seo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.produk_seo_id_seq OWNER TO postgres;

--
-- Name: produk_seo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.produk_seo_id_seq OWNED BY public.produk_seo.id;


--
-- Name: produks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.produks (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    category_id bigint NOT NULL,
    nama_produk character varying(255) NOT NULL,
    deskripsi text,
    harga bigint NOT NULL,
    stok integer DEFAULT 0 NOT NULL,
    gambar character varying(255),
    status character varying(255) DEFAULT 'aktif'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    jumlah_peringatan integer DEFAULT 0 NOT NULL,
    peringatan_terakhir timestamp(0) without time zone,
    is_banned boolean DEFAULT false NOT NULL,
    banned_sampai timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT produks_status_check CHECK (((status)::text = ANY ((ARRAY['aktif'::character varying, 'nonaktif'::character varying])::text[])))
);


ALTER TABLE public.produks OWNER TO postgres;

--
-- Name: produks_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.produks_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.produks_id_seq OWNER TO postgres;

--
-- Name: produks_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.produks_id_seq OWNED BY public.produks.id;


--
-- Name: promo_banners; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.promo_banners (
    id bigint NOT NULL,
    judul character varying(255) NOT NULL,
    deskripsi text,
    gambar character varying(255),
    tombol_teks character varying(255),
    tombol_url character varying(255),
    mulai_tanggal date,
    selesai_tanggal date,
    is_aktif boolean DEFAULT true NOT NULL,
    urutan integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.promo_banners OWNER TO postgres;

--
-- Name: promo_banners_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.promo_banners_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.promo_banners_id_seq OWNER TO postgres;

--
-- Name: promo_banners_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.promo_banners_id_seq OWNED BY public.promo_banners.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: testimonials; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.testimonials (
    id bigint NOT NULL,
    nama character varying(255) NOT NULL,
    jabatan character varying(255),
    nama_bisnis character varying(255),
    foto character varying(255),
    isi_testimoni text NOT NULL,
    rating smallint DEFAULT '5'::smallint NOT NULL,
    is_aktif boolean DEFAULT true NOT NULL,
    urutan integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.testimonials OWNER TO postgres;

--
-- Name: testimonials_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.testimonials_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.testimonials_id_seq OWNER TO postgres;

--
-- Name: testimonials_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.testimonials_id_seq OWNED BY public.testimonials.id;


--
-- Name: tiket_bantuan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tiket_bantuan (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    kategori_bantuan_id bigint,
    no_tiket character varying(255) NOT NULL,
    subjek character varying(255) NOT NULL,
    pesan text NOT NULL,
    status character varying(255) DEFAULT 'menunggu'::character varying NOT NULL,
    prioritas character varying(255) DEFAULT 'sedang'::character varying NOT NULL,
    balasan text,
    dibalas_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT tiket_bantuan_prioritas_check CHECK (((prioritas)::text = ANY ((ARRAY['rendah'::character varying, 'sedang'::character varying, 'tinggi'::character varying])::text[]))),
    CONSTRAINT tiket_bantuan_status_check CHECK (((status)::text = ANY ((ARRAY['menunggu'::character varying, 'dalam_proses'::character varying, 'selesai'::character varying, 'ditutup'::character varying])::text[])))
);


ALTER TABLE public.tiket_bantuan OWNER TO postgres;

--
-- Name: tiket_bantuan_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tiket_bantuan_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tiket_bantuan_id_seq OWNER TO postgres;

--
-- Name: tiket_bantuan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tiket_bantuan_id_seq OWNED BY public.tiket_bantuan.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    nama_bisnis character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    no_hp character varying(20) NOT NULL,
    tgl_lahir date NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    role character varying(255) DEFAULT 'user'::character varying NOT NULL,
    sisa_peringatan_produk integer DEFAULT 3 NOT NULL,
    is_banned_produk boolean DEFAULT false NOT NULL,
    banned_produk_sampai timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    status character varying(255) DEFAULT 'aktif'::character varying NOT NULL,
    CONSTRAINT users_role_check CHECK (((role)::text = ANY ((ARRAY['user'::character varying, 'owner'::character varying, 'admin'::character varying, 'manager'::character varying, 'staff'::character varying])::text[]))),
    CONSTRAINT users_status_check CHECK (((status)::text = ANY ((ARRAY['aktif'::character varying, 'nonaktif'::character varying, 'blokir'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: faq id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.faq ALTER COLUMN id SET DEFAULT nextval('public.faq_id_seq'::regclass);


--
-- Name: features id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.features ALTER COLUMN id SET DEFAULT nextval('public.features_id_seq'::regclass);


--
-- Name: hero_sections id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hero_sections ALTER COLUMN id SET DEFAULT nextval('public.hero_sections_id_seq'::regclass);


--
-- Name: invoice_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.invoice_details ALTER COLUMN id SET DEFAULT nextval('public.invoice_details_id_seq'::regclass);


--
-- Name: invoices id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.invoices ALTER COLUMN id SET DEFAULT nextval('public.invoices_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: kata_terlarang id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kata_terlarang ALTER COLUMN id SET DEFAULT nextval('public.kata_terlarang_id_seq'::regclass);


--
-- Name: kategori_bantuan id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kategori_bantuan ALTER COLUMN id SET DEFAULT nextval('public.kategori_bantuan_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: page_seo id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.page_seo ALTER COLUMN id SET DEFAULT nextval('public.page_seo_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: product_violations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_violations ALTER COLUMN id SET DEFAULT nextval('public.product_violations_id_seq'::regclass);


--
-- Name: produk_seo id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produk_seo ALTER COLUMN id SET DEFAULT nextval('public.produk_seo_id_seq'::regclass);


--
-- Name: produks id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produks ALTER COLUMN id SET DEFAULT nextval('public.produks_id_seq'::regclass);


--
-- Name: promo_banners id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promo_banners ALTER COLUMN id SET DEFAULT nextval('public.promo_banners_id_seq'::regclass);


--
-- Name: testimonials id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.testimonials ALTER COLUMN id SET DEFAULT nextval('public.testimonials_id_seq'::regclass);


--
-- Name: tiket_bantuan id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tiket_bantuan ALTER COLUMN id SET DEFAULT nextval('public.tiket_bantuan_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories (id, user_id, nama_category, created_at, updated_at, deleted_at) FROM stdin;
1	1	Makanan & Minuman	2026-06-11 06:18:46	2026-06-11 06:20:57	\N
2	1	Makanan	2026-06-11 18:21:58	2026-06-11 18:21:58	\N
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: faq; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.faq (id, kategori_bantuan_id, pertanyaan, jawaban, is_aktif, urutan, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: features; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.features (id, judul, deskripsi, ikon, is_aktif, urutan, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: hero_sections; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.hero_sections (id, judul, subjudul, gambar, tombol_teks, tombol_url, is_aktif, urutan, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: invoice_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.invoice_details (id, invoice_id, produk_id, nama_produk, harga, qty, subtotal, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: invoices; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.invoices (id, user_id, no_invoice, nama_pelanggan, no_hp_pelanggan, total_harga, total_bayar, kembalian, status, metode_bayar, catatan, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: kata_terlarang; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kata_terlarang (id, kata, jenis, keterangan, is_aktif, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: kategori_bantuan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kategori_bantuan (id, nama, ikon, deskripsi, is_aktif, urutan, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_05_31_091230_create_categories_table	1
5	2026_05_31_091238_create_produks_table	1
6	2026_05_31_091244_create_invoices_table	1
7	2026_05_31_091250_create_invoice_details_table	1
8	2026_05_31_103634_create_personal_access_tokens_table	1
9	2026_06_01_101907_add_columns_to_produks_table	1
10	2026_06_01_102007_create_product_violations_table	1
11	2026_06_01_102014_create_kata_terlarang_table	1
12	2026_06_01_102022_add_role_to_users_table	1
13	2026_05_31_050133_create_personal_access_tokens_table	1
14	2026_06_12_061420_create_kategori_bantuan_table	2
15	2026_06_12_061438_create_faq_table	2
16	2026_06_12_061450_create_tiket_bantuan_table	2
17	2026_06_14_161125_add_soft_deletes_to_tables	3
18	2026_06_14_212335_create_produk_seo_table	4
19	2026_06_14_212345_create_page_seo_table	4
20	2026_06_14_212355_create_hero_sections_table	4
21	2026_06_14_212404_create_promo_banners_table	4
22	2026_06_14_212412_create_features_table	4
23	2026_06_14_212421_create_testimonials_table	4
24	2026_06_15_124413_update_role_and_add_status_to_users_table	5
\.


--
-- Data for Name: page_seo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.page_seo (id, page_key, meta_title, meta_description, meta_keywords, slug, og_image, is_aktif, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
22	App\\Models\\User	3	auth_token	82ba8fac815fbf22a9e4c1c3fcc72383e31ad7c45e87b73d71dde42b46c7aa77	["*"]	\N	\N	2026-06-11 18:20:37	2026-06-11 18:20:37
24	App\\Models\\User	1	auth_token	17a00cbde645b4f6bbeabfe5aa58f37ee940b797d4296245d20721faf9b19991	["*"]	2026-06-11 18:24:08	\N	2026-06-11 18:24:06	2026-06-11 18:24:08
\.


--
-- Data for Name: product_violations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product_violations (id, produk_id, user_id, jenis_pelanggaran, keterangan, peringatan_ke, dikirim_at, created_at, updated_at, deleted_at) FROM stdin;
1	1	1	harga_nol	Produk memiliki harga Rp 0	1	2026-06-11 06:22:23	2026-06-11 06:22:23	2026-06-11 06:22:23	\N
\.


--
-- Data for Name: produk_seo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.produk_seo (id, produk_id, meta_title, meta_description, meta_keywords, slug, og_image, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: produks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.produks (id, user_id, category_id, nama_produk, deskripsi, harga, stok, gambar, status, created_at, updated_at, jumlah_peringatan, peringatan_terakhir, is_banned, banned_sampai, deleted_at) FROM stdin;
1	1	1	Nasi Goreng Spesial	Nasi goreng dengan telur dan ayam	15000	50	\N	aktif	2026-06-11 06:22:18	2026-06-11 06:22:25	1	2026-06-11 06:22:25	t	2026-06-12 06:22:25	\N
\.


--
-- Data for Name: promo_banners; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.promo_banners (id, judul, deskripsi, gambar, tombol_teks, tombol_url, mulai_tanggal, selesai_tanggal, is_aktif, urutan, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
yRE9LWK5YQ5QEN6423Q9kzmfVULiEmK2mrBqErxZ	\N	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.122.1 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36	eyJfdG9rZW4iOiI4bWgxak9GWkQyQXVyTFdNRzZzWjRNaGl5bWtmaUJDN1Q0WFBvUDBrIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19	1780550854
xPSs8Zv31RzKEY1qmzMTkEsJTBi1DA0uYEpbjL6i	\N	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0	eyJfdG9rZW4iOiJIcnNSelU1ZlhtUDdDR0wwUDFrTzJXYnFOdzY4WHd3WWJPdGE4ekhqIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9vd25lclwvZGFzaGJvYXJkIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19	1780963014
3DnPrF9SQBUBuBYwKcAhUzQu8jZmFBL1wyC3WkLu	\N	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0	eyJfdG9rZW4iOiJiNllQcktocVM2RENNTkpFY2cwN3liUzRSSXdSQ2xub1FMcVZ3ZFNaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9vd25lclwvZGFzaGJvYXJkIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19	1781016368
ppIYZQRr9weqmWsebgYGoXH19FGswb7llNFvFeDs	\N	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0	eyJfdG9rZW4iOiJwT2dJTE8yUUNvNWYzUlo5ZU5yNWFoQlI3eE16b0F5UWdDYWxYRFg4IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9vd25lclwvZGFzaGJvYXJkIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19	1781082596
PsI222ZgZZPbxkySGu3WwuosELkgTXp8iUBGiUu0	\N	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0	eyJfdG9rZW4iOiIyN21IZ3FvYTdONkpYcXpkcTFSNXRVR0tRVnMwMVBJNGY2b2doclh0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9vd25lclwvZGFzaGJvYXJkIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19	1781177047
\.


--
-- Data for Name: testimonials; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.testimonials (id, nama, jabatan, nama_bisnis, foto, isi_testimoni, rating, is_aktif, urutan, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: tiket_bantuan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tiket_bantuan (id, user_id, kategori_bantuan_id, no_tiket, subjek, pesan, status, prioritas, balasan, dibalas_at, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, nama_bisnis, email, no_hp, tgl_lahir, email_verified_at, password, remember_token, created_at, updated_at, role, sisa_peringatan_produk, is_banned_produk, banned_produk_sampai, deleted_at, status) FROM stdin;
2	Andrean Ahmad Fauzi	Toko Andrean	andrean@kelolain.com	08100000002	1999-05-10	\N	$2y$12$ijO7NdoydasRNV.x8kcafuYtZPVaebNcqPzHHlFchl5fdnsvKdMn.	\N	2026-06-04 12:07:27	2026-06-04 12:07:27	user	3	f	\N	\N	aktif
3	Naufal Febriansyah	Toko Naufal	naufal@kelolain.com	08100000003	2000-01-15	\N	$2y$12$iI92nJIhGGL1/m7XyMHS9.58wxcXeLUNPQr3d/hvPJHvsneq7HH16	\N	2026-06-04 12:07:28	2026-06-04 12:07:28	user	3	f	\N	\N	aktif
4	Ghibran Aryasena Aviyanto	Toko Ghibran	ghibran@kelolain.com	08100000004	2001-03-20	\N	$2y$12$XVTiZLWG8rd6Nx2QiJAyW.Egmx9vADYi2TeZCqo61q4608syftx.m	\N	2026-06-04 12:07:28	2026-06-04 12:07:28	user	3	f	\N	\N	aktif
5	Marfuah Zahra	Toko Marfuah	marfuah@kelolain.com	08100000005	2001-07-25	\N	$2y$12$Tte//DAffU4FVlDAxo2AsO/wcMBZrwhwqPua55QBcGsWzID4oL.Qa	\N	2026-06-04 12:07:28	2026-06-04 12:07:28	user	3	f	\N	\N	aktif
1	Michelle Agnesia	Kelolain	kelolainId@gmail.com	08100000001	1990-01-01	\N	$2y$12$G5Kipk0LQLa9mNLjf5Vr0.ssp2x7OI5y0FjXbQRQCC6g25K6eiKge	\N	2026-06-04 12:07:27	2026-06-11 06:22:25	owner	3	t	2026-06-12 06:22:25	\N	aktif
\.


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_id_seq', 2, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: faq_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.faq_id_seq', 1, false);


--
-- Name: features_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.features_id_seq', 1, false);


--
-- Name: hero_sections_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.hero_sections_id_seq', 1, false);


--
-- Name: invoice_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.invoice_details_id_seq', 1, false);


--
-- Name: invoices_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.invoices_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: kata_terlarang_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kata_terlarang_id_seq', 1, false);


--
-- Name: kategori_bantuan_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kategori_bantuan_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 24, true);


--
-- Name: page_seo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.page_seo_id_seq', 1, false);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 24, true);


--
-- Name: product_violations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_violations_id_seq', 1, true);


--
-- Name: produk_seo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.produk_seo_id_seq', 1, false);


--
-- Name: produks_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.produks_id_seq', 1, true);


--
-- Name: promo_banners_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.promo_banners_id_seq', 1, false);


--
-- Name: testimonials_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.testimonials_id_seq', 1, false);


--
-- Name: tiket_bantuan_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tiket_bantuan_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 5, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: faq faq_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.faq
    ADD CONSTRAINT faq_pkey PRIMARY KEY (id);


--
-- Name: features features_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.features
    ADD CONSTRAINT features_pkey PRIMARY KEY (id);


--
-- Name: hero_sections hero_sections_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hero_sections
    ADD CONSTRAINT hero_sections_pkey PRIMARY KEY (id);


--
-- Name: invoice_details invoice_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.invoice_details
    ADD CONSTRAINT invoice_details_pkey PRIMARY KEY (id);


--
-- Name: invoices invoices_no_invoice_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.invoices
    ADD CONSTRAINT invoices_no_invoice_unique UNIQUE (no_invoice);


--
-- Name: invoices invoices_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.invoices
    ADD CONSTRAINT invoices_pkey PRIMARY KEY (id);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: kata_terlarang kata_terlarang_kata_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kata_terlarang
    ADD CONSTRAINT kata_terlarang_kata_unique UNIQUE (kata);


--
-- Name: kata_terlarang kata_terlarang_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kata_terlarang
    ADD CONSTRAINT kata_terlarang_pkey PRIMARY KEY (id);


--
-- Name: kategori_bantuan kategori_bantuan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kategori_bantuan
    ADD CONSTRAINT kategori_bantuan_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: page_seo page_seo_page_key_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.page_seo
    ADD CONSTRAINT page_seo_page_key_unique UNIQUE (page_key);


--
-- Name: page_seo page_seo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.page_seo
    ADD CONSTRAINT page_seo_pkey PRIMARY KEY (id);


--
-- Name: page_seo page_seo_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.page_seo
    ADD CONSTRAINT page_seo_slug_unique UNIQUE (slug);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: product_violations product_violations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_violations
    ADD CONSTRAINT product_violations_pkey PRIMARY KEY (id);


--
-- Name: produk_seo produk_seo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produk_seo
    ADD CONSTRAINT produk_seo_pkey PRIMARY KEY (id);


--
-- Name: produk_seo produk_seo_produk_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produk_seo
    ADD CONSTRAINT produk_seo_produk_id_unique UNIQUE (produk_id);


--
-- Name: produk_seo produk_seo_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produk_seo
    ADD CONSTRAINT produk_seo_slug_unique UNIQUE (slug);


--
-- Name: produks produks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produks
    ADD CONSTRAINT produks_pkey PRIMARY KEY (id);


--
-- Name: promo_banners promo_banners_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promo_banners
    ADD CONSTRAINT promo_banners_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: testimonials testimonials_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.testimonials
    ADD CONSTRAINT testimonials_pkey PRIMARY KEY (id);


--
-- Name: tiket_bantuan tiket_bantuan_no_tiket_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tiket_bantuan
    ADD CONSTRAINT tiket_bantuan_no_tiket_unique UNIQUE (no_tiket);


--
-- Name: tiket_bantuan tiket_bantuan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tiket_bantuan
    ADD CONSTRAINT tiket_bantuan_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_no_hp_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_no_hp_unique UNIQUE (no_hp);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: failed_jobs_connection_queue_failed_at_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX failed_jobs_connection_queue_failed_at_index ON public.failed_jobs USING btree (connection, queue, failed_at);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: personal_access_tokens_expires_at_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_expires_at_index ON public.personal_access_tokens USING btree (expires_at);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: categories categories_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: faq faq_kategori_bantuan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.faq
    ADD CONSTRAINT faq_kategori_bantuan_id_foreign FOREIGN KEY (kategori_bantuan_id) REFERENCES public.kategori_bantuan(id) ON DELETE SET NULL;


--
-- Name: invoice_details invoice_details_invoice_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.invoice_details
    ADD CONSTRAINT invoice_details_invoice_id_foreign FOREIGN KEY (invoice_id) REFERENCES public.invoices(id) ON DELETE CASCADE;


--
-- Name: invoice_details invoice_details_produk_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.invoice_details
    ADD CONSTRAINT invoice_details_produk_id_foreign FOREIGN KEY (produk_id) REFERENCES public.produks(id) ON DELETE CASCADE;


--
-- Name: invoices invoices_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.invoices
    ADD CONSTRAINT invoices_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: product_violations product_violations_produk_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_violations
    ADD CONSTRAINT product_violations_produk_id_foreign FOREIGN KEY (produk_id) REFERENCES public.produks(id) ON DELETE CASCADE;


--
-- Name: product_violations product_violations_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_violations
    ADD CONSTRAINT product_violations_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: produk_seo produk_seo_produk_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produk_seo
    ADD CONSTRAINT produk_seo_produk_id_foreign FOREIGN KEY (produk_id) REFERENCES public.produks(id) ON DELETE CASCADE;


--
-- Name: produks produks_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produks
    ADD CONSTRAINT produks_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- Name: produks produks_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produks
    ADD CONSTRAINT produks_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: tiket_bantuan tiket_bantuan_kategori_bantuan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tiket_bantuan
    ADD CONSTRAINT tiket_bantuan_kategori_bantuan_id_foreign FOREIGN KEY (kategori_bantuan_id) REFERENCES public.kategori_bantuan(id) ON DELETE SET NULL;


--
-- Name: tiket_bantuan tiket_bantuan_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tiket_bantuan
    ADD CONSTRAINT tiket_bantuan_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict O6kAER2wGmvJArIgmaVNEgvmVtqAf5naM9PzrAgFs2BKCV3yUWpfP50jNbxVg4Z


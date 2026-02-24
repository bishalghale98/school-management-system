// School website data types

export interface Page {
    id: number;
    title: string;
    slug: string;
    content: string | null;
    excerpt: string | null;
    featured_image: string | null;
    meta_title: string | null;
    meta_description: string | null;
    og_image: string | null;
    status: 'draft' | 'published';
    published_at: string | null;
    sort_order: number;
    created_at: string;
    updated_at: string;
}

export interface PostCategory {
    id: number;
    name: string;
    slug: string;
    posts_count?: number;
}

export interface Post {
    id: number;
    title: string;
    slug: string;
    category_id: number;
    category?: PostCategory;
    content: string | null;
    excerpt: string | null;
    featured_image: string | null;
    is_pinned: boolean;
    meta_title: string | null;
    meta_description: string | null;
    og_image: string | null;
    status: 'draft' | 'published';
    published_at: string | null;
    attachments?: PostAttachment[];
    created_at: string;
    updated_at: string;
}

export interface PostAttachment {
    id: number;
    post_id: number;
    file_path: string;
    file_name: string;
    file_type: string | null;
    file_size: number | null;
}

export interface DownloadCategory {
    id: number;
    name: string;
    slug: string;
    downloads_count?: number;
}

export interface Download {
    id: number;
    title: string;
    description: string | null;
    category_id: number;
    category?: DownloadCategory;
    file_path: string | null;
    external_url: string | null;
    type: 'file' | 'link';
    is_featured: boolean;
    status: 'draft' | 'published';
    published_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface GalleryAlbum {
    id: number;
    title: string;
    slug: string;
    description: string | null;
    cover_image: string | null;
    event_date: string | null;
    status: 'draft' | 'published';
    published_at: string | null;
    photos?: GalleryPhoto[];
    photos_count?: number;
    created_at: string;
    updated_at: string;
}

export interface GalleryPhoto {
    id: number;
    album_id: number;
    image_path: string;
    caption: string | null;
    sort_order: number;
}

export interface AdmissionSetting {
    id: number;
    is_open: boolean;
    content: string | null;
    requirements: string[] | null;
}

export interface AdmissionApplication {
    id: number;
    student_name: string;
    guardian_name: string;
    email: string | null;
    phone: string;
    address: string | null;
    applying_class: string;
    previous_school: string | null;
    documents: string[] | null;
    status: 'pending' | 'reviewed' | 'accepted' | 'rejected';
    admin_notes: string | null;
    created_at: string;
    updated_at: string;
}

export interface ContactMessage {
    id: number;
    name: string;
    email: string | null;
    phone: string | null;
    subject: string;
    message: string;
    status: 'unread' | 'read';
    created_at: string;
    updated_at: string;
}

export interface SiteSettings {
    id: number;
    site_name: string;
    tagline: string | null;
    logo: string | null;
    address: string | null;
    phone_1: string | null;
    phone_2: string | null;
    email_1: string | null;
    email_2: string | null;
    facebook_url: string | null;
    youtube_url: string | null;
    twitter_url: string | null;
    instagram_url: string | null;
    map_url: string | null;
    map_embed_code: string | null;
}

export interface PaginatedData<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    links: PaginationLink[];
}

export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface DashboardStats {
    pages: number;
    posts: number;
    albums: number;
    downloads: number;
    pendingAdmissions: number;
    unreadMessages: number;
}

export interface FlashMessages {
    success: string | null;
    error: string | null;
}

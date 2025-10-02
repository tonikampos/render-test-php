export interface ApiResponse<T> {
  success: boolean;
  message: string;
  data: T;
  details?: any;
}

export interface PaginatedResponse<T> {
  items: T[];
  pagination: {
    total: number;
    per_page: number;
    current_page: number;
    total_pages: number;
    has_next: boolean;
    has_prev: boolean;
  };
}

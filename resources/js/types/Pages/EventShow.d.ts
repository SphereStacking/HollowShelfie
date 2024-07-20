export interface EventShow extends Record<string, unknown> {
  trendTags: string[];
  event: {
    id: number;
    alias: string;
    created_at: string;
    title: string;
    description: string;
    category_names: string[];
    tags: string[];
    status: string;
    create_user: {
        id: number;
        profile_url: string;
        name: string;
        image_url: string;
    };
    start_date: string;
    end_date: string;
    good_count: number;
    short_good_count: number;
    files: {
        id: number;
        public_url: string;
    }[];
    organizers: {
        profile_url: string;
        id: number;
        type: string;
        image_url: string;
        name: string;
    }[];
    performers: {
        id: number;
        profile_url: string;
        name: string;
        type: string;
        image_url: string;
    }[];
    time_table: {
        id: number;
        description: string;
        start_date: string;
        end_date: string;
        performers: {
            id: number;
            profile_url: string;
            name: string;
            type: string;
            image_url: string;
        }[];
    }[];
    instances: {
        instance_type: string;
        access_url: string;
        display_name: string;
    }[];
    auth_user: {
        is_good: boolean;
        is_bookmark: boolean;
        is_owner: boolean;
    };
  }
}

// ConnectedAccount インターフェースの定義
export interface ConnectedAccount {
  id: number;
  user_id: number;
  provider: string;
  provider_id: string;
  name: string;
  nickname: string | null;
  email: string;
  telephone: string | null;
  avatar_path: string;
  token: string;
  secret: string | null;
  refresh_token: string | null;
  expires_at: string;
  created_at: string;
  updated_at: string;
}

// Permission インターフェースの定義
export interface Permission {
  id: number;
  created_at: string;
  updated_at: string;
  name: string;
  description: string;
  permission_denied_message: string | null;
  pivot: {
      role_id: number;
      permission_id: number;
  };
}

// Role インターフェースの定義
export interface Role {
  id: number;
  created_at: string;
  updated_at: string;
  name: string;
  description: string;
  pivot: {
      user_id: number;
      role_id: number;
  };
  permissions: Permission[];
}

// User インターフェースの定義
export interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at: string;
  current_team_id: number | null;
  profile_photo_path: string;
  created_at: string;
  updated_at: string;
  two_factor_confirmed_at: string | null;
  bio: string | null;
  profile_photo_url: string;
  screen_name: string;
  connected_accounts: ConnectedAccount[];
  roles: Role[];
  owned_teams: any[]; // TODO: 型を定義
  teams: any[]; // TODO: 型を定義
  all_teams: any[]; // TODO: 型を定義
  permissions: string[];
  two_factor_enabled: boolean;
}

export interface SharedData {
  auth?: {
      user: User;
  } | null;
  config: {
    appName: string;
    twitter: string;
    github: string;
    discordInvite: string;
    credit: string;
    issueForms: {
        bug_report: string;
        feedback: string;
        new_feature: string;
    };
    supportings: {
        fanbox: string;
        patreon: string;
    };
  }
}

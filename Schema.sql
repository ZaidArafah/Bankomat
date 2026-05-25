
create table users (
    id integer primary key autoincrement,
    card_number text not null unique,
    pin_hash text not null,
    name  text not null,
    role text not null default 'user',
    created_at text default (datetime('now'))   
);


create table accounts (
    id integer primary key autoincrement,
    user_id integer not null references users(id),
    account_type text not null default 'checking',
    balance real not null default 0.0,
    created_at text default (datetime('now'))
);


create table transactions (
    id integer primary key autoincrement,
    from_account_id integer references accounts(id),
    to_account_id integer references accounts(id),
    type text not null,
    amount real not null,
    created_at text default (datetime('now'))
);    
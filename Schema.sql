
create table users (
    id int primary key autoincrement,
    card_number varchar text not null unique,
    pinhash varchar text not null,
    name varchar text not null,
    role varchar text not null default 'user',
    created_at text default (datetime('now'))   
);


create table accounts (
    id int primary key autoincrement,
    user_id integer not null references users(id),
    account_type text not null default 'checking',
    balance real not null default 0.0,
    created_at text default (datetime('now'))
);


create table transactions (
    id int primary key autoincrement,
    from_account_id integer references accounts(id),
    to_account_id integer references accounts(id),
    type text not null,
    amount real not null,
    created_at text default (datetime('now'))
);    
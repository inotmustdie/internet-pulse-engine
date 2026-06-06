# Incident Scenarios

## DNS Root Degradation

Root DNS degradation can increase global lookup latency and put pressure on recursive resolver cache behaviour.

Operational checks:

- authoritative DNS diversity;
- recursive resolver failover;
- TTL strategy;
- synchronous DNS lookups inside application code.

## Cloud Region Loss

A major cloud region outage can expose hidden coupling between services, data replication, and edge routing.

Operational checks:

- active/passive or active/active failover;
- replication lag;
- deploy and rollback paths;
- origin shielding behaviour.

## Transit Route Leak

BGP route leaks can redirect, blackhole, or degrade traffic between unrelated networks.

Operational checks:

- BGP monitoring;
- RPKI/ROA coverage;
- transit provider diversity;
- CDN routing behaviour.

## Certificate Validation Failure

Certificate authority or OCSP degradation can break TLS handshakes and automated systems.

Operational checks:

- certificate renewal automation;
- OCSP stapling;
- clock drift;
- package manager and CI dependency paths.
